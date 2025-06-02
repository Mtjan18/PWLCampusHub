@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create New Event</h2>

    <form action="{{ route('panitia.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Event Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        {{-- Date --}}
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required value="{{ old('date') }}">
        </div>

        {{-- Time --}}
        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" name="time" class="form-control" required value="{{ old('time') }}">
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required value="{{ old('location') }}">
        </div>

        {{-- Poster Upload --}}
        <div class="mb-3">
            <label for="poster" class="form-label">Poster (optional)</label>
            <input type="file" name="poster" class="form-control" accept="image/*">
        </div>

        {{-- Registration Fee --}}
        <div class="mb-3">
            <label for="registration_fee" class="form-label">Registration Fee (Rp)</label>
            <input type="number" step="0.01" name="registration_fee" class="form-control" value="{{ old('registration_fee', 0) }}">
        </div>

        {{-- Max Participants --}}
        <div class="mb-3">
            <label for="max_participants" class="form-label">Max Participants</label>
            <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants', 0) }}">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-2"></i> Save Event
        </button>
    </form>
</div>
@endsection
