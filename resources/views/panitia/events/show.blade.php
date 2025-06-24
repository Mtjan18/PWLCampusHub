@extends('layouts.app')

@section('title', 'Detail Event - ' . $event->name)

@section('content')
<div class="container py-4">
    <div class="row g-4 align-items-start">
        <!-- Poster & Info -->
        <div class="col-lg-5">
            <div class="card shadow border-0 mb-3 animate__fadeInUp">
                <div class="event-poster position-relative">
                    <img src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}"
                         alt="{{ $event->name }}"
                         class="card-img-top rounded-top event-image"
                         style="object-fit:cover; height:320px;">
                    <span class="badge position-absolute top-0 end-0 m-3 {{ $event->status == 1 ? 'bg-success' : 'bg-danger' }} animate__fadeInDown">
                        <i class="bi bi-{{ $event->status == 1 ? 'check-circle' : 'x-circle' }}"></i>
                        {{ $event->status == 1 ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold mb-2 text-primary">{{ $event->name }}</h3>
                    <div class="mb-2 text-muted small">
                        Dibuat oleh: <span class="fw-semibold">{{ $event->creator->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if($event->registration_fee > 0)
                            <span class="badge bg-warning text-dark"><i class="bi bi-cash"></i> Rp{{ number_format($event->registration_fee,0,',','.') }}</span>
                        @else
                            <span class="badge bg-success"><i class="bi bi-gift"></i> Gratis</span>
                        @endif
                        <span class="badge bg-info text-dark">
                            <i class="bi bi-people"></i>
                            {{ $event->registrations_count ?? ($event->registrations->count() ?? 0) }}/{{ $event->max_participants > 0 ? $event->max_participants : '∞' }} Peserta
                        </span>
                    </div>
                    <div class="mb-2"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
                    <div class="mb-2"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</div>
                    <div class="mb-3"><i class="bi bi-geo-alt"></i> {{ $event->location }}</div>
                    <!-- Progress Bar Peserta -->
                    @if($event->max_participants > 0)
                        @php
                            $percent = min(100, round((($event->registrations_count ?? ($event->registrations->count() ?? 0)) / $event->max_participants) * 100));
                        @endphp
                        <div class="mb-2">
                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $percent }}%
                                </div>
                            </div>
                            <div class="small text-muted mt-1">Kapasitas peserta</div>
                        </div>
                    @endif
                </div>
                <div class="text-center mt-3 mb-3">
                    <a href="{{ route('panitia.sessions.create', $event->id) }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-plus-circle"></i> Tambah Sesi
                    </a>
                    <a href="{{ route('panitia.events.edit', $event->id) }}" class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-pencil-square"></i> Edit Event
                    </a>
                    <a href="{{ route('panitia.dashboard') }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
        <!-- Detail Event -->
        <div class="col-lg-7">
            <div class="card shadow border-0 animate__fadeInUp">
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="fw-semibold text-primary"><i class="bi bi-info-circle"></i> Deskripsi Event</h5>
                        <p class="mb-0">{{ $event->description ?? '-' }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="fw-semibold text-primary"><i class="bi bi-list-ol"></i> Daftar Sesi</h5>
                        @if($event->sessions && $event->sessions->count())
                            @foreach($event->sessions as $session)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $session->name }}</h5>
                                        <div class="mb-1 text-muted small">
                                            <i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }},
                                            <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }},
                                            <i class="bi bi-geo-alt"></i> {{ $session->location }}
                                        </div>
                                    </div>
                                    <div class="ms-md-3 mt-2 mt-md-0">
                                        <form action="{{ route('panitia.certificates.upload', [$event->id, $session->id]) }}"
                                              method="POST"
                                              enctype="multipart/form-data"
                                              class="d-inline">
                                            @csrf
                                            <input type="file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png" required
                                                   class="form-control form-control-sm d-inline w-auto">
                                            <button type="submit" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-upload"></i> Upload Sertifikat Sesi Ini
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-info mb-0">
                                Belum ada sesi.
                                @if(auth()->user() && auth()->user()->role->name == 'panitia')
                                    <a href="{{ route('panitia.sessions.create', $event->id) }}" class="btn btn-sm btn-primary ms-2">
                                        <i class="bi bi-plus-circle"></i> Tambah Sesi
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                    {{-- Contoh tambahan: Daftar Panitia --}}
                    @if(isset($event->committee) && count($event->committee))
                        <div class="mb-4">
                            <h5 class="fw-semibold text-primary"><i class="bi bi-people-fill"></i> Panitia Event</h5>
                            @foreach($event->committee as $panitia)
                                <span class="badge bg-dark mb-1">{{ $panitia->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Optional: Timeline CSS & Animasi --}}
<style>
.event-poster img.event-image {
    transition: transform 0.4s cubic-bezier(.4,2,.3,1);
}
.event-poster img.event-image:hover {
    transform: scale(1.04) rotate(-1deg);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15);
}
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
.animate__fadeInUp {
    animation: fadeInUp 0.8s ease forwards;
}
.animate__fadeInDown {
    animation: fadeInDown 0.8s ease forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px);}
    to { opacity: 1; transform: translateY(0);}
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px);}
    to { opacity: 1; transform: translateY(0);}
}
</style>
@endsection