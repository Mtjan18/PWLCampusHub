@extends('layouts.app')

@section('title', 'Edit Event - ' . $event->name)

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Event</h2>

    <form action="{{ route('panitia.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Event Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Event</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $event->name) }}" required>
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $event->date) }}" required>
        </div>

        {{-- Start Time --}}
        <div class="mb-3">
            <label for="start_time" class="form-label">Jam Mulai</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $event->start_time) }}" required>
        </div>

        {{-- End Time --}}
        <div class="mb-3">
            <label for="end_time" class="form-label">Jam Selesai</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $event->end_time) }}" required>
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" required>
        </div>

        {{-- Poster Upload --}}
        <div class="mb-3">
            <label for="poster" class="form-label">Poster Event (opsional, biarkan kosong jika tidak ingin mengganti)</label>
            <input type="file" name="poster" id="poster" class="form-control" accept="image/*">
            @if($event->poster_url)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $event->poster_url) }}" alt="Poster" style="max-width: 200px;">
                </div>
            @endif
        </div>

        {{-- Registration Fee --}}
        <div class="mb-3">
            <label for="registration_fee" class="form-label">Biaya Pendaftaran (Rp)</label>
            <input type="number" name="registration_fee" id="registration_fee" class="form-control" min="0" value="{{ old('registration_fee', $event->registration_fee) }}" required>
        </div>

        {{-- Max Participants --}}
        <div class="mb-3">
            <label for="max_participants" class="form-label">Maksimal Peserta</label>
            <input type="number" name="max_participants" id="max_participants" class="form-control" min="0" value="{{ old('max_participants', $event->max_participants) }}">
            <small class="text-muted">Isi 0 jika tidak ada batasan.</small>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status Event</label>
            <select name="status" id="status" class="form-select">
                <option value="1" {{ $event->status == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $event->status == 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="{{ route('panitia.events.show', $event->id) }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection