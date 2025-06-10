{{-- filepath: resources/views/tim_keuangan/payments/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Payment Detail')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Payment Detail</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Event</dt>
                        <dd class="col-sm-8">{{ $registration->session->event->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Session</dt>
                        <dd class="col-sm-8">{{ $registration->session->name ?? '-' }}</dd>

                        <dt class="col-sm-4">User</dt>
                        <dd class="col-sm-8">{{ $registration->user->name ?? '-' }} ({{ $registration->user->email ?? '-' }})</dd>

                        <dt class="col-sm-4">Amount</dt>
                        <dd class="col-sm-8">Rp{{ number_format($registration->session->event->registration_fee ?? 0,0,',','.') }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if($registration->payment_status == 1)
                                <span class="badge bg-success">Verified</span>
                            @elseif($registration->payment_status == 0)
                                <span class="badge bg-warning">Pending</span>
                            @elseif($registration->payment_status == 2)
                                <span class="badge bg-danger">Refund</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Registered At</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($registration->registered_at)->format('d M Y H:i') }}</dd>

                        <dt class="col-sm-4">Payment Proof</dt>
                        <dd class="col-sm-8">
                            @if($registration->payment_proof_url)
                                @if(Str::endsWith(strtolower($registration->payment_proof_url), ['.jpg', '.jpeg', '.png']))
                                    <img src="{{ asset('storage/' . $registration->payment_proof_url) }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-2" style="max-width:300px;">
                                @else
                                    <a href="{{ asset('storage/' . $registration->payment_proof_url) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                    </a>
                                @endif
                            @else
                                <span class="text-muted">No file uploaded</span>
                            @endif
                        </dd>

                        @if($registration->payment_status == 1 && $registration->qr_code)
                        <dt class="col-sm-4">QR Code</dt>
                        <dd class="col-sm-8">
                            <img src="{{ asset('storage/' . $registration->qr_code) }}" alt="QR Code" class="img-fluid" style="max-width:200px;">
                        </dd>
                        @endif
                    </dl>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('tim_keuangan.dashboard') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection