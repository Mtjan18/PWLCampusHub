@extends('layouts.app')

@section('title', 'Scan Attendance')

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Kamera Scan QR -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow border-0 animate__fadeInUp">
                    <div class="card-body text-center">
                        <h4 class="mb-3"><i class="bi bi-qr-code-scan"></i> Scan QR-Code Peserta</h4>
                        <div id="reader"
                            style="width:320px; max-width:100%; margin:0 auto; border-radius: 1rem; overflow: hidden; box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.08);">
                        </div>
                        <div class="my-3">
                            <label for="qr-upload" class="form-label">Atau upload gambar QR:</label>
                            <input type="file" id="qr-upload" accept="image/*" class="form-control"
                                style="max-width:300px; margin:0 auto;">
                        </div>
                        <div id="result" class="mt-3 text-center" style="min-height:40px;"></div>
                    </div>
                </div>
            </div>
            <!-- Pilih Event, Sesi, dan Tabel Peserta -->
            <div class="col-lg-7">
                <div class="card shadow border-0 animate__fadeInUp mb-3">
                    <div class="card-body">
                        <form method="GET" id="filter-form" class="row g-2 align-items-end mb-3">
                            <div class="col-md-6">
                                <label for="event_id" class="form-label fw-semibold">Pilih Event</label>
                                <select name="event_id" id="event_id" class="form-select" required>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}"
                                            {{ $selectedEventId == $event->id ? 'selected' : '' }}>
                                            {{ $event->name }} ({{ \Carbon\Carbon::parse($event->date)->format('d M Y') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="session_id" class="form-label fw-semibold">Pilih Sesi</label>
                                <select name="session_id" id="session_id" class="form-select" required>
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session->id }}"
                                            {{ $selectedSessionId == $session->id ? 'selected' : '' }}>
                                            {{ $session->name }} ({{ $session->session_date }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Peserta</th>
                                        <th>Email</th>
                                        <th>Status Hadir</th>
                                    </tr>
                                </thead>
                                <tbody id="participant-table">
                                    @forelse($registrations as $reg)
                                        <tr id="row-{{ $reg->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $reg->user->name }}</td>
                                            <td>{{ $reg->user->email }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $reg->attendances->count() ? 'bg-success' : 'bg-secondary' }}"
                                                    id="status-{{ $reg->id }}">
                                                    {{ $reg->attendances->count() ? 'Hadir' : 'Belum Hadir' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada peserta terdaftar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const resultDiv = document.getElementById('result');
        let lastScanned = '';
        let isProcessing = false;

        function showResult(status, message) {
            if (status === 'success') {
                resultDiv.innerHTML = '<span class="text-success fw-bold fs-5"><i class="bi bi-check-circle"></i> ' +
                    message + '</span>';
            } else if (status === 'already') {
                resultDiv.innerHTML = '<span class="text-warning fw-bold fs-5"><i class="bi bi-exclamation-circle"></i> ' +
                    message + '</span>';
            } else {
                resultDiv.innerHTML = '<span class="text-danger fw-bold fs-5"><i class="bi bi-x-circle"></i> ' + message +
                    '</span>';
            }
        }

        function updateAttendanceStatus(registrationId) {
            const badge = document.getElementById('status-' + registrationId);
            if (badge) {
                badge.className = 'badge bg-success';
                badge.innerText = 'Hadir';
            }
        }

        const html5Qr = new Html5Qrcode("reader");
        html5Qr.start({
                facingMode: "environment"
            }, {
                fps: 15,
                qrbox: 250
            },
            onScanSuccess
        );

        function onScanSuccess(decodedText) {
            if (decodedText !== lastScanned && !isProcessing) {
                lastScanned = decodedText;
                isProcessing = true;
                resultDiv.innerHTML =
                    '<span class="text-info fw-semibold"><i class="bi bi-hourglass-split"></i> Memproses presensi...</span>';
                fetch("{{ route('panitia.attendance.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            qr_data: decodedText,
                            session_id: document.getElementById('session_id').value
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        showResult(data.status, data.message);
                        if (data.status === 'success' && data.registration_id) {
                            updateAttendanceStatus(data.registration_id);
                        }
                        setTimeout(() => {
                            isProcessing = false;
                            lastScanned = '';
                            resultDiv.innerHTML = '';
                        }, 1200); // Lebih singkat
                    })
                    .catch(() => {
                        showResult('error', 'Terjadi kesalahan koneksi.');
                        isProcessing = false;
                        lastScanned = '';
                    });
            }
        }

        // Ganti sesi/event reload form
        document.getElementById('event_id').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
        document.getElementById('session_id').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        // Fungsi scan dari gambar
        document.getElementById('qr-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            Html5Qrcode.getCameras(); // agar lib ter-load
            const qr = new Html5Qrcode(/* element id */ "reader-upload-temp");
            qr.scanFile(file, true)
                .then(decodedText => {
                    onScanSuccess(decodedText);
                })
                .catch(err => {
                    showResult('error', 'QR tidak terdeteksi di gambar.');
                });
        });

        // Tambahkan elemen dummy untuk scan gambar (tidak tampil)
        if (!document.getElementById('reader-upload-temp')) {
            const tempDiv = document.createElement('div');
            tempDiv.id = 'reader-upload-temp';
            tempDiv.style.display = 'none';
            document.body.appendChild(tempDiv);
        }
    </script>
@endsection
