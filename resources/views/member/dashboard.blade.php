@extends('layouts.app')

@section('title', 'Member Dashboard - UniEvent')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="dashboard-title">Member Dashboard</h2>
                <p class="text-muted">Welcome back, {{ $user->name }}! Here's an overview of your events and activities.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Registered Events</div>
                            <div class="dashboard-card-icon bg-primary-light">
                                <i class="bi bi-calendar2-check text-primary"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">{{ $registeredEvents }}</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $registeredEvents > 0 ? round($upcomingEvents/$registeredEvents*100) : 0 }}%"
                                    aria-valuenow="{{ $registeredEvents > 0 ? round($upcomingEvents/$registeredEvents*100) : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">{{ $upcomingEvents }} upcoming, {{ $completedEvents }} completed</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Certificates</div>
                            <div class="dashboard-card-icon bg-success-light">
                                <i class="bi bi-award text-success"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">{{ $certificatesCount }}</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $certificatesCount > 0 ? round($certificatesCount/$registeredEvents*100) : 0 }}%"
                                    aria-valuenow="{{ $certificatesCount > 0 ? round($certificatesCount/$registeredEvents*100) : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">{{ $certificatesCount }} earned, {{ $pendingCertificates }} pending</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Payments</div>
                            <div class="dashboard-card-icon bg-warning-light">
                                <i class="bi bi-credit-card text-warning"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">Rp{{ number_format($totalPaid,0,',','.') }}</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">Total spent on events</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Attendance</div>
                            <div class="dashboard-card-icon bg-info-light">
                                <i class="bi bi-person-check text-info"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">{{ $totalAttendance }}/{{ $totalSessions }}</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalSessions > 0 ? round($totalAttendance/$totalSessions*100) : 0 }}%" aria-valuenow="{{ $totalSessions > 0 ? round($totalAttendance/$totalSessions*100) : 0 }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">{{ $totalSessions > 0 && $totalAttendance == $totalSessions ? 'Perfect attendance rate' : 'Keep attending!' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Upcoming Events</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Payment Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($registrations->where('session.session_date', '>=', now()) as $registration)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $registration->session->event->name ?? '-' }}</div>
                                            <div class="small text-muted">{{ $registration->session->name ?? '-' }}</div>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($registration->session->session_date)->format('F d, Y') }}
                                            <br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($registration->session->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($registration->session->end_time)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>{{ $registration->session->location ?? '-' }}</td>
                                        <td>
                                            @if($registration->payment_status == 1)
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($registration->payment_status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton{{ $registration->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $registration->id }}">
                                                    <li><a class="dropdown-item" href="{{ route('events.show', $registration->session->event->id) }}">View Details</a></li>
                                                    @if($registration->payment_status == 0)
                                                        <li><a class="dropdown-item" href="{{ route('member.payments.upload', $registration->id) }}">Upload Payment</a></li>
                                                    @endif
                                                    @if($registration->payment_status == 1 && $registration->qr_code)
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#qrModal{{ $registration->id }}">Show QR Code</a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <form action="{{ route('member.registrations.cancel', $registration->id) }}" method="POST" onsubmit="return confirm('Cancel registration?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="dropdown-item text-danger" type="submit">Cancel Registration</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                            {{-- Modal QR Code --}}
                                            @if($registration->payment_status == 1 && $registration->qr_code)
                                            <div class="modal fade" id="qrModal{{ $registration->id }}" tabindex="-1" aria-labelledby="qrModalLabel{{ $registration->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="qrModalLabel{{ $registration->id }}">QR Code for {{ $registration->session->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $registration->qr_code) }}" alt="QR Code" class="img-fluid" style="max-width:200px;">
                                                            <div class="mt-2 text-success">Tunjukkan QR code ini saat absen sesi!</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No upcoming events.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('member.events') }}" class="btn btn-sm btn-primary">View All Events</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Certificates and Payment History -->
        <div class="row g-4">
            <!-- Latest Certificates -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Latest Certificates</h5>
                        <a href="{{ route('member.certificates') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @forelse($certificates as $certificate)
                        <div class="certificate-item d-flex mb-3">
                            <div class="certificate-preview me-3">
                                <img src="{{ asset('images/certificate.png') }}" alt="Certificate" width="80">
                                <a href="{{ $certificate->certificate_url }}" class="certificate-download" download>
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                            <div class="certificate-details">
                                <h6 class="mb-1">{{ $certificate->registration->event->name }}</h6>
                                <div class="text-muted small">Issued on: {{ \Carbon\Carbon::parse($certificate->uploaded_at)->format('F d, Y') }}</div>
                                <div class="mt-2">
                                    <a href="{{ $certificate->certificate_url }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary ms-1">Share</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-muted">No certificates yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Payments</h5>
                        <a href="{{ route('member.payments') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPayments as $registration)
                                    <tr>
                                        <td>{{ $registration->session->event->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($registration->session->event->date)->format('F d, Y') }}</td>
                                        <td>Rp{{ number_format($registration->session->event->registration_fee,0,',','.') }}</td>
                                        <td>
                                            @if($registration->payment_status == 1)
                                                <span class="badge bg-success">Confirmed</span>
                                            @elseif($registration->payment_status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No payment history.</td>
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
@endsection