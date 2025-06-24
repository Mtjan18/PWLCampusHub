@extends('layouts.app')

@section('title', $event->name . ' - Detail Event')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <!-- Poster & Info -->
            <div class="col-lg-5">
                <div class="card shadow border-0 mb-3">
                    <img src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}"
                        alt="{{ $event->name }}" class="card-img-top rounded-top event-image"
                        style="object-fit:cover; height:320px;">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge {{ $event->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                <i class="bi bi-{{ $event->status == 1 ? 'check-circle' : 'x-circle' }}"></i>
                                {{ $event->status == 1 ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            @if ($event->registration_fee > 0)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-cash"></i> Rp{{ number_format($event->registration_fee, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="bi bi-gift"></i> Gratis
                                </span>
                            @endif
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-people"></i>
                                {{ $event->registrations_count ?? ($event->registrations->count() ?? 0) }}/{{ $event->max_participants > 0 ? $event->max_participants : '∞' }}
                                Peserta
                            </span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-clock"></i>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB
                        </div>
                        <div>
                            <i class="bi bi-geo-alt"></i>
                            {{ $event->location }}
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('member.events') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Event
                    </a>
                </div>
            </div>
            <!-- Detail Event -->
            <div class="col-lg-7">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h2 class="fw-bold mb-1">{{ $event->name }}</h2>
                        <div class="mb-3 text-muted small">
                            Diselenggarakan oleh: <span class="fw-semibold">{{ $event->creator->name ?? '-' }}</span>
                        </div>
                        <div class="mb-4 text-center">
                            <h5 class="fw-semibold mb-3">Poster Event</h5>
                            <img src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}"
                                alt="{{ $event->name }}" class="img-fluid rounded shadow"
                                style="max-width: 100%; height: auto;">
                            <div class="small text-muted mt-2">Klik kanan dan pilih "Buka gambar di tab baru" untuk
                                memperbesar.</div>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-semibold">Daftar Sesi Event</h5>
                            @if ($event->sessions && $event->sessions->count())
                                <form action="{{ route('member.sessions.register', $event->id) }}" method="POST"
                                    enctype="multipart/form-data" id="sessionForm">
                                    @csrf
                                    <div id="total-fee" class="alert alert-info mb-3" style="display:none;">
                                        Total yang harus dibayar: <strong>Rp<span id="fee-amount">0</span></strong>
                                    </div>
                                    <div class="timeline mb-3">
                                        @foreach ($event->sessions as $session)
                                            @php
                                                $alreadyRegistered =
                                                    $session->registrations->where('user_id', auth()->id())->count() >
                                                    0;
                                            @endphp
                                            <div class="timeline-item mb-4">
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                                    <strong>{{ $session->name }}</strong>
                                                </div>
                                                <div class="mb-1">
                                                    <i class="bi bi-calendar-event"></i>
                                                    {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }},
                                                    <i class="bi bi-clock"></i>
                                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }} WIB,
                                                    <i class="bi bi-geo-alt"></i> {{ $session->location }}
                                                    <span
                                                        class="badge bg-warning text-dark ms-2">Rp{{ number_format($session->fee ?? 0, 0, ',', '.') }}</span>
                                                </div>
                                                @if ($session->speakers && $session->speakers->count())
                                                    <div class="mb-1">
                                                        <i class="bi bi-mic"></i> Pembicara:
                                                        @foreach ($session->speakers as $speaker)
                                                            <span class="badge bg-secondary">{{ $speaker->name }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input session-checkbox" type="checkbox"
                                                            name="session_ids[]" value="{{ $session->id }}"
                                                            data-fee="{{ $session->fee ?? 0 }}"
                                                            id="session_{{ $session->id }}"
                                                            {{ $alreadyRegistered ? 'checked disabled' : '' }}>
                                                        <label class="form-check-label" for="session_{{ $session->id }}">
                                                            @if ($alreadyRegistered)
                                                                <span class="badge bg-success">Sudah Terdaftar di sesi
                                                                    ini</span>
                                                            @else
                                                                Pilih untuk daftar sesi ini
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($event->status == 1)
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran (jpg, png,
                                                pdf)</label>
                                            <input type="file" name="payment_proof" id="payment_proof"
                                                class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Daftar & Upload Bukti</button>
                                    @else
                                        <span class="badge bg-secondary">Pendaftaran Ditutup</span>
                                    @endif
                                </form>
                            @else
                                <div class="alert alert-info mb-0">
                                    Belum ada sesi untuk event ini.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline CSS --}}
    <style>
        .timeline {
            border-left: 3px solid #0d6efd;
            margin-left: 10px;
            padding-left: 20px;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -28px;
            top: 8px;
            width: 14px;
            height: 14px;
            background: #fff;
            border: 3px solid #0d6efd;
            border-radius: 50%;
            z-index: 1;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.session-checkbox');
            const totalFeeDiv = document.getElementById('total-fee');
            const feeAmount = document.getElementById('fee-amount');

            function updateTotalFee() {
                let total = 0;
                let checked = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked && !cb.disabled) {
                        total += parseFloat(cb.dataset.fee);
                        checked++;
                    }
                });
                feeAmount.textContent = total.toLocaleString('id-ID');
                totalFeeDiv.style.display = checked > 0 ? 'block' : 'none';
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateTotalFee);
            });
            updateTotalFee();
        });
    </script>
@endsection
