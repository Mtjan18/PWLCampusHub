@extends('layouts.app')

@section('title', 'Committee Dashboard - UniEvent')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="dashboard-title">Committee Dashboard</h2>
                <p class="text-muted">Manage your events, attendance, and certificates efficiently.</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex flex-wrap gap-2">
                        <a href="{{ route('panitia.events.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> New Event
                        </a>
                        <a href="{{ route('panitia.attendance.scan') }}" class="btn btn-success">
                            <i class="bi bi-qr-code-scan me-2"></i> Scan Attendance
                        </a>
                        {{-- <a href="{{ route('panitia.certificates.upload') }}" class="btn btn-info text-white">
                            <i class="bi bi-upload me-2"></i> Upload Certificates
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Your Events</div>
                            <div class="dashboard-card-icon bg-primary-light">
                                <i class="bi bi-calendar-event text-primary"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">{{ $eventCount }}</div>
                        <div class="small mt-1">{{ $activeCount }} active, {{ $completedCount }} completed</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Registrations</div>
                            <div class="dashboard-card-icon bg-success-light">
                                <i class="bi bi-people text-success"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">{{ $registrationTotal }}</div>
                        <div class="small mt-1">{{ $weeklyRegistration }} this week</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Attendance Rate</div>
                            <div class="dashboard-card-icon bg-warning-light">
                                <i class="bi bi-person-check text-warning"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">{{ $attendanceRate }}%</div>
                        <div class="small mt-1">Across your events</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Events -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Active Events</h5>
                        <a href="{{-- {{ route('panitia.events.index') }} --}}" class="btn btn-sm btn-primary">All Events</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Event</th>
                                        <th scope="col">Date & Time</th>
                                        <th scope="col">Participants</th>
                                        <th scope="col">Fee</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activeEvents as $event)
                                        <tr>
                                            <td>
                                                <strong>{{ $event->title }}</strong>
                                                <div class="text-muted small">{{ $event->location }}</div>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}<br>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span
                                                    class="{{ $event->registrations_count >= $event->max_participants ? 'text-danger fw-semibold' : '' }}">
                                                    {{ $event->registrations_count }}/{{ $event->max_participants }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($event->registration_fee > 0)
                                                    <span class="badge bg-warning text-dark">Rp
                                                        {{ number_format($event->registration_fee, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="badge bg-success">Free</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($event->registrations_count >= $event->max_participants)
                                                    <span class="badge bg-danger" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Participant limit reached">Full</span>
                                                @else
                                                    <span class="badge bg-success" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Open for registration">Open</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('panitia.events.show', $event->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-gear me-1"></i> Manage
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No active events
                                                available.</td>
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
