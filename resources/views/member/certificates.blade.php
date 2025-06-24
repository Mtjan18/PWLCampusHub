{{-- filepath: resources/views/member/certificates.blade.php --}}
@extends('layouts.app')

@section('title', 'My Certificates - UniEvent')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">My Certificates</h2>
    <div class="row g-4">
        @forelse($certificates as $certificate)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-0 animate__fadeInUp">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/certificate.png') }}" alt="Certificate" width="48" class="me-3">
                        <div>
                            <div class="fw-semibold">{{ $certificate->registration?->session?->event?->name ?? '-' }}</div>
                            <div class="small text-muted">{{ $certificate->registration?->session?->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="mb-2 text-muted small">
                        Issued on: {{ \Carbon\Carbon::parse($certificate->uploaded_at)->format('d M Y') }}
                    </div>
                    <div class="mt-auto d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm w-100"
                           data-bs-toggle="modal"
                           data-bs-target="#certificateModal"
                           data-img="{{ asset('storage/' . $certificate->certificate_url) }}"
                           data-type="{{ pathinfo($certificate->certificate_url, PATHINFO_EXTENSION) }}">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ asset('storage/' . $certificate->certificate_url) }}" class="btn btn-outline-success btn-sm w-100" download>
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-award display-3 mb-3"></i>
            <h5>No certificates yet.</h5>
            <p class="mb-0">Certificates from attended events will appear here.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Preview Certificate -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0 text-center">
        <span id="certificateContent"></span>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('certificateModal');
    const content = document.getElementById('certificateContent');
    document.querySelectorAll('[data-bs-target="#certificateModal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-img');
            const ext = this.getAttribute('data-type').toLowerCase();
            if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)) {
                content.innerHTML = `<img src="${url}" class="img-fluid rounded shadow" style="max-height:70vh;">`;
            } else if(ext === 'pdf') {
                content.innerHTML = `<iframe src="${url}" style="width:100%;height:70vh;" frameborder="0"></iframe>`;
            } else {
                content.innerHTML = `<a href="${url}" target="_blank" class="btn btn-primary">Download File</a>`;
            }
        });
    });
    modal.addEventListener('hidden.bs.modal', function () {
        content.innerHTML = '';
    });
});
</script>
@endsection