{{-- filepath: resources/views/member/events.blade.php --}}
@extends('layouts.app')

@section('title', 'My Events - UniEvent')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">My Events</h2>
    <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">Upcoming</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">History</button>
        </li>
    </ul>
    <div class="tab-content" id="eventTabsContent">
        <!-- Upcoming Events -->
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            @if($upcomingRegistrations->count())
            <div class="row g-4">
                @foreach($upcomingRegistrations as $reg)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 event-card position-relative animate__fadeInUp">
                        <div class="event-image position-relative">
                            <img src="{{ $reg->session->event->poster_url ? asset('storage/' . $reg->session->event->poster_url) : asset('images/default-event.jpg') }}"
                                 alt="{{ $reg->session->event->name }}"
                                 class="card-img-top rounded-top"
                                 style="object-fit:cover; height:180px;">
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">Upcoming</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $reg->session->event->name }}</h5>
                            <div class="mb-2 text-muted small">{{ $reg->session->name }}</div>
                            <div class="mb-2">
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($reg->session->session_date)->format('d M Y') }}
                                <br>
                                <i class="bi bi-clock"></i>
                                {{ \Carbon\Carbon::parse($reg->session->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($reg->session->end_time)->format('H:i') }} WIB
                            </div>
                            <div class="mb-2"><i class="bi bi-geo-alt"></i> {{ $reg->session->location }}</div>
                            <div class="mb-2">
                                @if($reg->payment_status == 1)
                                    <span class="badge bg-success">Paid</span>
                                @elseif($reg->payment_status == 0)
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </div>
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('member.events.show', $reg->session->event->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                                @if($reg->payment_status == 1)
                                    <span class="badge bg-info align-self-center">Ready to Attend</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $upcomingRegistrations->withQueryString()->links() }}
            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-calendar-x display-3 mb-3"></i>
                <h5>No upcoming events.</h5>
                <p class="mb-0">Register for new events to see them here!</p>
            </div>
            @endif
        </div>
        <!-- History Events -->
        <div class="tab-pane fade" id="history" role="tabpanel">
            @if($historyRegistrations->count())
            <div class="timeline">
                @foreach($historyRegistrations as $reg)
                <div class="timeline-item mb-4 p-3 shadow-sm rounded bg-white animate__fadeInUp d-flex flex-column flex-md-row align-items-md-center">
                    <div class="flex-shrink-0 text-center me-md-4 mb-2 mb-md-0" style="min-width:100px;">
                        <span class="badge bg-primary fs-5 mb-2">{{ $loop->iteration }}</span>
                        <div>
                            <i class="bi bi-calendar-event"></i>
                            <div class="small">{{ \Carbon\Carbon::parse($reg->session->session_date)->format('d M Y') }}</div>
                        </div>
                        <div>
                            <i class="bi bi-clock"></i>
                            <div class="small">{{ \Carbon\Carbon::parse($reg->session->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($reg->session->end_time)->format('H:i') }}</div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-1">
                            <strong class="me-2 fs-5">{{ $reg->session->event->name }}</strong>
                            <span class="badge ms-2 {{ $reg->attendances->where('session_id', $reg->session_id)->count() ? 'bg-success' : 'bg-secondary' }}">
                                <i class="bi {{ $reg->attendances->where('session_id', $reg->session_id)->count() ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                {{ $reg->attendances->where('session_id', $reg->session_id)->count() ? 'Attended' : 'Missed' }}
                            </span>
                            @if($reg->certificate)
                                <span class="badge bg-info ms-2"><i class="bi bi-award"></i> Certificate</span>
                            @endif
                        </div>
                        <div class="mb-1 text-muted small">
                            <i class="bi bi-geo-alt"></i> {{ $reg->session->location }}
                            <span class="badge bg-light text-dark ms-2">{{ $reg->session->name }}</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <a href="{{ route('member.events.show', $reg->session->event->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-info-circle"></i> Event Detail
                            </a>
                            @if($reg->certificate)
                                <a href="{{ $reg->certificate->certificate_url }}" class="btn btn-outline-success btn-sm" target="_blank">
                                    <i class="bi bi-award"></i> View Certificate
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $historyRegistrations->withQueryString()->links() }}
            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-clock-history display-3 mb-3"></i>
                <h5>No event history yet.</h5>
                <p class="mb-0">Your attended events will appear here.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.event-card {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.08);
    transition: transform .2s, box-shadow .2s;
}
.event-card:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.13);
}
.timeline {
    border-left: 3px solid #0d6efd;
    margin-left: 10px;
    padding-left: 20px;
}
.timeline-item {
    position: relative;
    background: #fff;
}
.timeline-item:before {
    content: '';
    position: absolute;
    left: -28px;
    top: 18px;
    width: 14px;
    height: 14px;
    background: #fff;
    border: 3px solid #0d6efd;
    border-radius: 50%;
    z-index: 1;
}
</style>
@endsection