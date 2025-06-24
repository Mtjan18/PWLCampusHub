<!-- resources/views/panitia/certificates/upload.blade.php -->
@extends('layouts.app')
@section('title', 'Upload Sertifikat Sesi: ' . $session->name)

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Upload Sertifikat - <span class="text-primary">{{ $session->name }}</span></h2>
    <div class="mb-4">
        <form action="{{ route('panitia.certificates.uploadMassal', [$event->id, $session->id]) }}" method="POST" enctype="multipart/form-data" class="card card-body shadow-sm mb-3">
            @csrf
            <div class="mb-3">
                <label for="zip_file" class="form-label">Upload ZIP Sertifikat <span class="text-muted">(format: sertifikat_{registration_id}.pdf)</span></label>
                <input type="file" name="zip_file" id="zip_file" class="form-control" accept=".zip" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Upload Massal</button>
        </form>
    </div>
    <form action="{{ route('panitia.certificates.upload', [$event->id, $session->id]) }}" method="POST" enctype="multipart/form-data" class="card card-body shadow-sm">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Status Hadir</th>
                        <th>Upload Sertifikat</th>
                        <th>Lihat Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendedRegistrations as $reg)
                    <tr>
                        <td>{{ $reg->user->name }}</td>
                        <td>{{ $reg->user->email }}</td>
                        <td><span class="badge bg-success">Hadir</span></td>
                        <td>
                            <input type="file" name="certificates[{{ $reg->id }}]" accept=".pdf,.jpg,.jpeg,.png">
                        </td>
                        <td>
                            @if($reg->certificate)
                                <a href="{{ asset('storage/' . $reg->certificate->certificate_url) }}" target="_blank" class="btn btn-sm btn-outline-success">Lihat</a>
                            @else
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Upload Sertifikat</button>
    </form>
</div>
@endsection