@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Sesi</h1>

    <form action="{{ route('panitia.sessions.store', ['event' => $event->id]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Untuk Event</label>
            <input type="text" class="form-control" value="{{ $event->name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Sesi</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Event</label>
            <input type="text" class="form-control mb-1" value="{{ $event->date }}" disabled>

            <label for="session_date" class="form-label">Tanggal Sesi</label>
            <input type="date" class="form-control" id="session_date" name="session_date" required min="{{ $event->date }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Event</label>
            <div class="d-flex gap-2 mb-1">
                <input type="text" class="form-control" value="{{ $event->start_time }}" disabled>
                <input type="text" class="form-control" value="{{ $event->end_time }}" disabled>
            </div>

            <label for="start_time" class="form-label">Start Time Sesi</label>
            <input type="time" class="form-control mb-2" id="start_time" name="start_time" required>

            <label for="end_time" class="form-label">End Time Sesi</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Lokasi Event</label>
            <input type="text" class="form-control mb-1" value="{{ $event->location }}" disabled>

            <label for="location" class="form-label">Lokasi Sesi</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Sesi (Rp)</label>
            <input type="number" class="form-control" id="fee" name="fee" min="0" step="1000" value="0" required>
            <small class="text-muted">Isi 0 jika sesi gratis.</small>
        </div>

        <hr>
        <h5>Speakers</h5>

        <div id="speaker-container" class="mb-3">
            <!-- Speaker inputs akan ditambahkan di sini -->
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addSpeakerField()">+ Tambah Speaker</button>

        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<!-- Script JS -->
<script>
    function addSpeakerField() {
        const container = document.getElementById('speaker-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'speakers[]';
        input.classList.add('form-control', 'mb-2');
        input.placeholder = 'Nama Speaker';
        input.required = true;
        container.appendChild(input);
    }
</script>
@endsection
