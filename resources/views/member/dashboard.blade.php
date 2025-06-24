@extends('layouts.app')

@section('title', 'Member Dashboard - UniEvent')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Welcome Banner -->
        <div class="card bg-primary text-white border-0 mb-4 welcome-card">
            <div class="card-body py-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1">Welcome back, {{ $user->name }}!</h2>
                        <p class="mb-0 opacity-75">Here's your event activity summary and upcoming sessions.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('member.events') }}" class="btn btn-light">
                            <i class="bi bi-calendar-plus"></i> Browse Events
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 stats-icon bg-primary-light text-primary">
                                <i class="bi bi-calendar2-check"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0 small">Registered Events</h6>
                                <h3 class="mb-0">{{ $registeredEvents }}</h3>
                            </div>
                        </div>
                        <div class="progress rounded-pill" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="small mt-2">
                            <span class="text-success"><i class="bi bi-calendar-check"></i> {{ $upcomingEvents }}</span>
                            upcoming,
                            <span class="text-secondary"><i class="bi bi-calendar-x"></i> {{ $completedEvents }}</span>
                            completed
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 stats-icon bg-success-light text-success">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0 small">Certificates</h6>
                                <h3 class="mb-0">{{ $certificatesCount }}</h3>
                            </div>
                        </div>
                        <div class="progress rounded-pill" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $registeredEvents > 0 ? ($certificatesCount / $registeredEvents) * 100 : 0 }}%"
                                aria-valuenow="{{ $registeredEvents > 0 ? ($certificatesCount / $registeredEvents) * 100 : 0 }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="small mt-2">
                            <span class="text-success">{{ $certificatesCount }}</span> earned,
                            <span class="text-secondary">{{ $pendingCertificates }}</span> pending
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 stats-icon bg-warning-light text-warning">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0 small">Total Payments</h6>
                                <h3 class="mb-0">Rp{{ number_format($totalPaid, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="progress rounded-pill" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="small mt-2">
                            <span class="text-muted"><i class="bi bi-info-circle"></i> Total spent on events</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card dashboard-stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 stats-icon bg-info-light text-info">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-0 small">Attendance</h6>
                                <h3 class="mb-0">{{ $totalAttendance }}/{{ $totalSessions }}</h3>
                            </div>
                        </div>
                        <div class="progress rounded-pill" style="height: 5px;">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ $totalSessions > 0 ? ($totalAttendance / $totalSessions) * 100 : 0 }}%"
                                aria-valuenow="{{ $totalSessions > 0 ? ($totalAttendance / $totalSessions) * 100 : 0 }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="small mt-2">
                            <span
                                class="text-muted">{{ $totalSessions > 0 && $totalAttendance == $totalSessions ? 'Perfect attendance rate' : 'Keep attending sessions!' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events - FIXED TO ONLY SHOW UNATTENDED EVENTS -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-calendar-event text-primary me-2"></i>Upcoming Events
                        </h5>
                        <a href="{{ route('member.events') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Date & Time</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Filter to show only upcoming registrations without attendance
                                        $upcomingRegistrations = $registrations
                                            ->filter(function ($reg) {
                                                return $reg->session &&
                                                    $reg->session->session_date >= \Carbon\Carbon::today() &&
                                                    $reg->attendances->where('session_id', $reg->session_id)->count() ==
                                                        0;
                                            })
                                            ->take(5);
                                    @endphp

                                    @forelse($upcomingRegistrations as $registration)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $registration->session->event->name ?? '-' }}
                                                </div>
                                                <div class="small text-muted">{{ $registration->session->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="bi bi-calendar3 text-primary me-1"></i>
                                                    {{ \Carbon\Carbon::parse($registration->session->session_date)->format('F d, Y') }}
                                                </div>
                                                <div class="small text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($registration->session->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($registration->session->end_time)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td>
                                                <i class="bi bi-geo-alt text-primary me-1"></i>
                                                {{ $registration->session->location ?? '-' }}
                                            </td>
                                            <td>
                                                @if ($registration->payment_status == 1)
                                                    <span class="badge bg-success"><i
                                                            class="bi bi-check-circle me-1"></i>Paid</span>
                                                @elseif($registration->payment_status == 0)
                                                    <span class="badge bg-warning text-dark"><i
                                                            class="bi bi-clock-history me-1"></i>Pending</span>
                                                @elseif($registration->payment_status == 2)
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Refunded/Canceled</span>
                                                    @if($registration->rejection_reason)
                                                        <div class="small text-danger mt-1">
                                                            <strong>Reason:</strong> {{ $registration->rejection_reason }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a class="btn btn-outline-primary btn-sm"
                                                        href="{{ route('member.events.show', $registration->session->event->id) }}">
                                                        <i class="bi bi-info-circle"></i> Details
                                                    </a>
                                                    @if ($registration->payment_status == 1 && $registration->qr_code)
                                                        <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#qrModal{{ $registration->id }}">
                                                            <i class="bi bi-qr-code"></i> QR Code
                                                        </button>
                                                    @endif
                                                </div>

                                                @if ($registration->payment_status == 1 && $registration->qr_code)
                                                    <div class="modal fade" id="qrModal{{ $registration->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="qrModalLabel{{ $registration->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="qrModalLabel{{ $registration->id }}">QR Code
                                                                        for {{ $registration->session->name }}</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/' . $registration->qr_code) }}"
                                                                        alt="QR Code" class="img-fluid"
                                                                        style="max-width:200px;">
                                                                    <div class="alert alert-success mt-3">
                                                                        <i class="bi bi-info-circle-fill me-2"></i>
                                                                        Show this QR code when checking in at the event!
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="bi bi-calendar-x display-6 d-block mb-2"></i>
                                                <p>You have no upcoming events.</p>
                                                <a href="{{ route('events') }}" class="btn btn-primary btn-sm">Browse
                                                    Events</a>
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

        <!-- Certificates & Payment History -->
        <div class="row g-4">
            <!-- Latest Certificates - FIXED TO ENABLE MODAL VIEW AND DOWNLOADS -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-award text-success me-2"></i>Latest Certificates
                        </h5>
                        <a href="{{ route('member.certificates') }}" class="btn btn-sm btn-outline-success">View All</a>
                    </div>
                    <div class="card-body">
                        @forelse($certificates as $certificate)
                            <div class="certificate-item d-flex align-items-center mb-3 p-3 border rounded hover-shadow">
                                <div class="certificate-preview flex-shrink-0 me-3">
                                    <div
                                        class="certificate-icon bg-light d-flex align-items-center justify-content-center rounded border">
                                        <i class="bi bi-file-earmark-text text-success fs-3"></i>
                                    </div>
                                </div>
                                <div class="certificate-details flex-grow-1">
                                    <h6 class="mb-1">{{ $certificate->registration->session->event->name ?? 'Event' }}
                                    </h6>
                                    <div class="small text-muted mb-2">
                                        {{ $certificate->registration->session->name ?? 'Session' }}</div>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#certificateModal"
                                            data-img="{{ asset('storage/' . $certificate->certificate_url) }}"
                                            data-type="{{ pathinfo($certificate->certificate_url, PATHINFO_EXTENSION) }}">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('member.certificate.download', $certificate->id) }}"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-award text-muted display-5 mb-3"></i>
                                <p>No certificates available yet.</p>
                                <p class="small text-muted">Complete events to earn certificates</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Payments - NO CHANGE NEEDED -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-credit-card text-warning me-2"></i>Recent Payments
                        </h5>
                        <a href="{{ route('member.payments') }}" class="btn btn-sm btn-outline-warning">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-center">Receipt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPayments as $payment)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $payment->session->event->name ?? '-' }}</div>
                                                <div class="small text-muted">{{ $payment->session->name ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    Rp{{ number_format($payment->session->fee ?? 0, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($payment->payment_status == 1)
                                                    <span class="badge bg-success">Verified</span>
                                                @elseif($payment->payment_status == 0)
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($payment->payment_status == 2)
                                                    <span class="badge bg-danger">Refund/Canceled</span>
                                                    @if($payment->rejection_reason)
                                                        <div class="small text-danger mt-1">
                                                            <strong>Reason:</strong> {{ $payment->rejection_reason }}
                                                            {{-- @if($payment->rejection_notes)
                                                                <br><strong>Notes:</strong> {{ $payment->rejection_notes }}
                                                            @endif --}}
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($payment->payment_proof_url)
                                                    <a href="#" class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal" data-bs-target="#paymentProofModal"
                                                        data-img="{{ asset('storage/' . $payment->payment_proof_url) }}"
                                                        data-type="{{ pathinfo($payment->payment_proof_url, PATHINFO_EXTENSION) }}">
                                                        <i class="bi bi-file-earmark"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-credit-card display-6 d-block mb-2"></i>
                                                <p>No payment records yet.</p>
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

    <!-- Payment Proof Modal -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <span id="paymentProofContent"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Modal - ADDED FOR POPUP VIEW -->
    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <span id="certificateContent"></span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .welcome-card {
            background: linear-gradient(45deg, #0062cc, #007bff);
            border-radius: 15px;
        }

        .dashboard-stat-card {
            border-radius: 15px;
            transition: transform 0.2s;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
        }

        .bg-primary-light {
            background-color: rgba(13, 110, 253, 0.15);
        }

        .bg-success-light {
            background-color: rgba(25, 135, 84, 0.15);
        }

        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.15);
        }

        .bg-info-light {
            background-color: rgba(13, 202, 240, 0.15);
        }

        .certificate-icon {
            width: 60px;
            height: 60px;
        }

        .hover-shadow {
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle payment proof modal
            const paymentModal = document.getElementById('paymentProofModal');
            const paymentContent = document.getElementById('paymentProofContent');

            // NEW: Handle certificate modal
            const certModal = document.getElementById('certificateModal');
            const certContent = document.getElementById('certificateContent');

            document.querySelectorAll('[data-bs-target="#certificateModal"]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-img');
                    const ext = this.getAttribute('data-type').toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(ext)) {
                        certContent.innerHTML = `
                    <img src="${url}" class="img-fluid rounded shadow" style="max-height:80vh;">
                    <button type="button" class="btn-close position-absolute top-0 end-0 bg-white m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                `;
                    } else if (ext === 'pdf') {
                        certContent.innerHTML = `
                    <div class="bg-white rounded shadow p-2">
                        <iframe src="${url}" style="width:100%;height:80vh;" frameborder="0"></iframe>
                        <button type="button" class="btn-close position-absolute top-0 end-0 bg-white m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                `;
                    } else {
                        certContent.innerHTML = `
                    <div class="bg-white rounded shadow p-4">
                        <p>File cannot be displayed directly.</p>
                        <a href="${url}" target="_blank" class="btn btn-primary">Download File</a>
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                `;
                    }
                });
            });

            certModal.addEventListener('hidden.bs.modal', function() {
                certContent.innerHTML = '';
            });

            document.querySelectorAll('[data-bs-target="#paymentProofModal"]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-img');
                    const ext = this.getAttribute('data-type').toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(ext)) {
                        paymentContent.innerHTML = `
                    <img src="${url}" class="img-fluid rounded shadow" style="max-height:80vh;">
                    <button type="button" class="btn-close position-absolute top-0 end-0 bg-white m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                `;
                    } else if (ext === 'pdf') {
                        paymentContent.innerHTML = `
                    <div class="bg-white rounded shadow p-2">
                        <iframe src="${url}" style="width:100%;height:80vh;" frameborder="0"></iframe>
                        <button type="button" class="btn-close position-absolute top-0 end-0 bg-white m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                `;
                    } else {
                        paymentContent.innerHTML = `
                    <div class="bg-white rounded shadow p-4">
                        <p>File cannot be displayed directly.</p>
                        <a href="${url}" target="_blank" class="btn btn-primary">Download File</a>
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                `;
                    }
                });
            });

            paymentModal.addEventListener('hidden.bs.modal', function() {
                paymentContent.innerHTML = '';
            });
        });
    </script>
@endsection
