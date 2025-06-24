{{-- filepath: resources/views/member/payments.blade.php --}}
@extends('layouts.app')

@section('title', 'Payment History - UniEvent')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Payment History</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Session</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $reg->session?->event?->name ?? '-' }}</div>
                            </td>
                            <td>
                                <div>{{ $reg->session?->name ?? '-' }}</div>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($reg->session?->session_date)->format('d M Y') }}
                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($reg->session?->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reg->session?->end_time)->format('H:i') }}
                                </small>
                            </td>
                            <td>
                                Rp{{ number_format($reg->session?->fee ?? 0,0,',','.') }}
                            </td>
                            <td>
                                @if($reg->payment_status == 1)
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($reg->payment_status == 0)
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($reg->payment_status == 2)
                                    <span class="badge bg-danger">Refunded</span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($reg->payment_proof_url)
                                    <a href="#" class="btn btn-sm btn-outline-info"
                                       data-bs-toggle="modal"
                                       data-bs-target="#paymentProofModal"
                                       data-img="{{ asset('storage/' . $reg->payment_proof_url) }}"
                                       data-type="{{ pathinfo($reg->payment_proof_url, PATHINFO_EXTENSION) }}">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-credit-card display-5 mb-2"></i>
                                <div>No payment history yet.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Payment Proof -->
<div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0 text-center">
        <span id="paymentProofContent"></span>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('paymentProofModal');
    const content = document.getElementById('paymentProofContent');
    document.querySelectorAll('[data-bs-target="#paymentProofModal"]').forEach(btn => {
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