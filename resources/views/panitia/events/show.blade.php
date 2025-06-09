@extends('layouts.app')

@section('title', 'Detail Event - ' . $event->name)

@section('content')
<div class="container py-4">
    <div class="row g-4 align-items-start">
        <!-- Poster & Info -->
        <div class="col-lg-5">
            <div class="card shadow border-0 mb-3">
                <img src="{{ $event->poster_url ?? asset('images/default-event.jpg') }}" class="card-img-top rounded-top" alt="{{ $event->name }}" style="object-fit:cover; height:320px;">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <span class="badge {{ $event->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            <i class="bi bi-{{ $event->status == 1 ? 'check-circle' : 'x-circle' }}"></i>
                            {{ $event->status == 1 ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        @if($event->registration_fee > 0)
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-cash"></i> Rp{{ number_format($event->registration_fee,0,',','.') }}
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="bi bi-gift"></i> Gratis
                            </span>
                        @endif
                        <span class="badge bg-info text-dark">
                            <i class="bi bi-people"></i>
                            {{ $event->registrations_count ?? ($event->registrations->count() ?? 0) }}/{{ $event->max_participants > 0 ? $event->max_participants : '∞' }} Peserta
                        </span>
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-clock"></i>
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB
                    </div>
                    <div>
                        <i class="bi bi-geo-alt"></i>
                        {{ $event->location }}
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('panitia.sessions.create', $event->id) }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-plus-circle"></i> Tambah Sesi
                </a>
                <a href="{{ route('panitia.dashboard') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
        <!-- Detail Event -->
        <div class="col-lg-7">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h2 class="fw-bold mb-1">{{ $event->name }}</h2>
                    <div class="mb-3 text-muted small">
                        Dibuat oleh: <span class="fw-semibold">{{ $event->creator->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="fw-semibold">Deskripsi Event</h5>
                        <p class="mb-0">{{ $event->description ?? '-' }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="fw-semibold">Daftar Sesi</h5>
                        @if($event->sessions && $event->sessions->count())
                            <div class="timeline">
                                @foreach($event->sessions as $session)
                                    <div class="timeline-item mb-4">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge bg-primary me-2">{{ $loop->iteration }}</span>
                                            <strong>{{ $session->name }}</strong>
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }},
                                            <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }} WIB,
                                            <i class="bi bi-geo-alt"></i> {{ $session->location }}
                                        </div>
                                        @if($session->speakers && $session->speakers->count())
                                            <div class="mb-1">
                                                <i class="bi bi-mic"></i> Pembicara:
                                                @foreach($session->speakers as $speaker)
                                                    <span class="badge bg-secondary">{{ $speaker->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                Belum ada sesi. <a href="{{ route('panitia.sessions.create', $event->id) }}" class="btn btn-sm btn-primary ms-2"><i class="bi bi-plus-circle"></i> Tambah Sesi</a>
                            </div>
                        @endif
                    </div>
                    <div>
                        {{-- Tambahkan fitur lain di sini, misal: daftar peserta, edit event, dsb --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Optional: Timeline CSS --}}
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
@endsection