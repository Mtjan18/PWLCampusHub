@extends('layouts.app')

@section('title', $event->name . ' - Detail Event')

@section('content')
    <!-- Event Hero Section -->
    <div class="event-hero position-relative mb-4" style="background-color: rgba(13, 110, 253, 0.05);">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mb-2">{{ $event->name }}</h1>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge {{ $event->status == 1 ? 'bg-success' : 'bg-danger' }} animate__animated animate__fadeIn">
                            <i class="bi bi-{{ $event->status == 1 ? 'check-circle' : 'x-circle' }}"></i>
                            {{ $event->status == 1 ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        @if ($event->registration_fee > 0)
                            <span class="badge bg-warning text-dark animate__animated animate__fadeIn">
                                <i class="bi bi-cash"></i> Rp{{ number_format($event->registration_fee, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="badge bg-success animate__animated animate__fadeIn">
                                <i class="bi bi-gift"></i> Gratis
                            </span>
                        @endif
                        <span class="badge bg-info text-dark animate__animated animate__fadeIn">
                            <i class="bi bi-people"></i>
                            {{ $event->registrations_count ?? ($event->registrations->count() ?? 0) }}/{{ $event->max_participants > 0 ? $event->max_participants : '∞' }}
                            Peserta
                        </span>
                    </div>
                    <div class="event-meta mb-4">
                        <div class="event-meta-item animate__animated animate__fadeIn">
                            <i class="bi bi-calendar-event text-primary"></i>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                        </div>
                        <div class="event-meta-item animate__animated animate__fadeIn" style="animation-delay: 100ms;">
                            <i class="bi bi-clock text-primary"></i>
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                        </div>
                        <div class="event-meta-item animate__animated animate__fadeIn" style="animation-delay: 200ms;">
                            <i class="bi bi-geo-alt text-primary"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                    </div>
                    <div class="text-muted animate__animated animate__fadeIn" style="animation-delay: 300ms;">
                        <span class="fw-semibold">Penyelenggara:</span> {{ $event->creator->name ?? 'UniEvent Team' }}
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <div class="poster-container position-relative d-inline-block animate__animated animate__zoomIn">
                        <img src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}"
                            alt="{{ $event->name }}" class="img-fluid rounded shadow" style="max-height: 300px; object-fit: contain;">
                        <div class="poster-overlay position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center">
                            <a href="#" class="btn btn-light btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#posterModal">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container pb-5">
        <div class="row g-4">
            <!-- Registration Form -->
            <div class="col-lg-8 order-lg-2">
                <div class="card shadow-sm border-0 rounded-3 mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Daftar Sesi Event</h4>
                    </div>
                    <div class="card-body">
                        @if ($event->sessions && $event->sessions->count())
                            <form action="{{ route('member.sessions.register', $event->id) }}" method="POST"
                                enctype="multipart/form-data" id="sessionForm">
                                @csrf
                                <div id="total-fee" class="alert alert-info d-flex align-items-center mb-4" style="display:none;">
                                    <i class="bi bi-info-circle-fill fs-4 me-2"></i>
                                    <div>Total yang harus dibayar: <strong>Rp<span id="fee-amount">0</span></strong></div>
                                </div>
                                
                                <div class="session-timeline">
                                    @foreach ($event->sessions as $session)
                                        @php
                                            $alreadyRegistered =
                                                $session->registrations->where('user_id', auth()->id())->count() > 0;
                                        @endphp
                                        <div class="session-item mb-4 animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->iteration * 100 }}ms">
                                            <div class="card border-0 shadow-sm hover-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="session-number">{{ $loop->iteration }}</div>
                                                        <h5 class="fw-bold mb-0 ms-2">{{ $session->name }}</h5>
                                                        @if($alreadyRegistered)
                                                            <span class="badge bg-success ms-auto"><i class="bi bi-check-lg me-1"></i>Terdaftar</span>
                                                        @endif
                                                    </div>

                                                    <div class="session-details mb-3 ps-4">
                                                        <div class="d-flex flex-wrap row-gap-2">
                                                            <div class="me-4">
                                                                <i class="bi bi-calendar-event text-primary"></i>
                                                                {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}
                                                            </div>
                                                            <div class="me-4">
                                                                <i class="bi bi-clock text-primary"></i>
                                                                {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} -
                                                                {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }} WIB
                                                            </div>
                                                            <div class="me-4">
                                                                <i class="bi bi-geo-alt text-primary"></i>
                                                                {{ $session->location }}
                                                            </div>
                                                            <div>
                                                                <span class="badge bg-warning text-dark">
                                                                    <i class="bi bi-cash-coin me-1"></i>
                                                                    Rp{{ number_format($session->fee ?? 0, 0, ',', '.') }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        @if ($session->speakers && $session->speakers->count())
                                                            <div class="mt-2">
                                                                <i class="bi bi-mic-fill text-primary"></i> Pembicara:
                                                                @foreach ($session->speakers as $speaker)
                                                                    <span class="badge bg-secondary me-1">{{ $speaker->name }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="form-check ps-4">
                                                        <input class="form-check-input session-checkbox" type="checkbox"
                                                            name="session_ids[]" value="{{ $session->id }}"
                                                            data-fee="{{ $session->fee ?? 0 }}"
                                                            id="session_{{ $session->id }}"
                                                            {{ $alreadyRegistered ? 'checked disabled' : '' }}>
                                                        <label class="form-check-label" for="session_{{ $session->id }}">
                                                            @if ($alreadyRegistered)
                                                                <span class="text-success">Anda sudah terdaftar di sesi ini</span>
                                                            @else
                                                                Pilih untuk daftar sesi ini
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($event->status == 1)
                                    <div class="payment-upload card border-light bg-light p-3 mb-3 animate__animated animate__fadeInUp">
                                        <h5><i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran</h5>
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Upload Bukti Pembayaran (jpg, png, pdf)</label>
                                            <input type="file" name="payment_proof" id="payment_proof" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
                                            <div class="form-text text-muted">Maksimal 2MB</div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>Daftar & Upload Bukti</button>
                                    </div>
                                @else
                                    <div class="alert alert-secondary animate__animated animate__fadeIn">
                                        <i class="bi bi-lock-fill me-2"></i>
                                        Pendaftaran untuk event ini sudah ditutup
                                    </div>
                                @endif
                            </form>
                        @else
                            <div class="alert alert-info mb-0 animate__animated animate__fadeIn">
                                <i class="bi bi-info-circle me-2"></i>
                                Belum ada sesi untuk event ini.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Navigation Button -->
                <div class="text-center mt-3 animate__animated animate__fadeIn">
                    <a href="{{ route('member.events') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Event
                    </a>
                </div>
            </div>

            <!-- Sidebar - Event Info -->
            <div class="col-lg-4 order-lg-1">
                <!-- Event Detail Card -->
                <div class="card shadow-sm border-0 rounded-3 mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary bg-opacity-10 py-3">
                        <h5 class="mb-0 text-primary"><i class="bi bi-info-circle me-2"></i>Detail Event</h5>
                    </div>
                    <div class="card-body">
                        @if($event->max_participants > 0)
                            @php
                                $registeredCount = $event->registrations_count ?? ($event->registrations->count() ?? 0);
                                $percent = min(100, round(($registeredCount / $event->max_participants) * 100));
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold">Kapasitas Peserta</span>
                                    <span>{{ $registeredCount }}/{{ $event->max_participants }}</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $percent > 80 ? 'danger' : ($percent > 50 ? 'warning' : 'success') }}" 
                                         role="progressbar" 
                                         style="width: {{ $percent }}%;" 
                                         aria-valuenow="{{ $percent }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="small text-muted mt-1">
                                    @if($percent > 90)
                                        <i class="bi bi-exclamation-triangle text-danger"></i> Hampir penuh!
                                    @elseif($percent > 70)
                                        <i class="bi bi-exclamation-circle text-warning"></i> Segera daftar!
                                    @else
                                        <i class="bi bi-check-circle text-success"></i> Masih tersedia
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="event-highlight mb-3 p-3 bg-light rounded">
                            <div class="row align-items-center text-center g-2">
                                <div class="col">
                                    <div class="fs-1 text-primary">{{ $event->sessions->count() }}</div>
                                    <div class="small text-muted">Sesi</div>
                                </div>
                                <div class="col">
                                    <div class="fs-1 text-primary">{{ $event->sessions->sum(function($session) { return $session->speakers->count(); }) }}</div>
                                    <div class="small text-muted">Pembicara</div>
                                </div>
                                <div class="col">
                                    <div class="fs-1 text-primary">
                                        @if($event->registration_fee > 0)
                                            <i class="bi bi-cash"></i>
                                        @else
                                            <i class="bi bi-gift"></i>
                                        @endif
                                    </div>
                                    <div class="small text-muted">
                                        @if($event->registration_fee > 0)
                                            Berbayar
                                        @else
                                            Gratis
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($event->description)
                            <div class="mb-3">
                                <h6 class="fw-bold">Deskripsi Event</h6>
                                <p class="mb-0">{{ $event->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Poster Modal -->
    <div class="modal fade" id="posterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <img src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}" 
                         alt="{{ $event->name }}" class="img-fluid rounded shadow" style="max-height:85vh;">
                    <button type="button" class="btn-close bg-white position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"></button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced styling for event show page */
        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
        }
        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .poster-container {
            transition: transform 0.3s ease;
            overflow: hidden;
            border-radius: 0.5rem;
        }
        .poster-container:hover {
            transform: scale(1.02);
        }
        .poster-overlay {
            opacity: 0;
            background-color: rgba(0,0,0,0.2);
            transition: opacity 0.3s ease;
            border-radius: 0.5rem;
        }
        .poster-container:hover .poster-overlay {
            opacity: 1;
        }
        .session-timeline {
            position: relative;
            padding-left: 1.5rem;
        }
        .session-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 24px;
            height: calc(100% - 48px);
            width: 2px;
            background-color: var(--bs-primary);
            opacity: 0.3;
        }
        .session-number {
            width: 30px;
            height: 30px;
            background-color: var(--bs-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
        }
        .hover-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .animate__animated {
            animation-duration: 0.6s;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate__fadeInUp {
            animation: fadeInUp 0.8s ease forwards;
        }
        .animate__fadeIn {
            animation: fadeIn 0.8s ease forwards;
        }
        .animate__zoomIn {
            animation: zoomIn 0.8s ease forwards;
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