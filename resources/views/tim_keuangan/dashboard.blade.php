@extends('layouts.app')

@section('title', 'Finance Dashboard - UniEvent')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="dashboard-title">Finance Dashboard</h2>
            <p class="text-muted">Monitor and manage event payments and financial transactions</p>
        </div>
    </div>
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="dashboard-card-title">Total Revenue</div>
                        <div class="dashboard-card-icon bg-primary-light">
                            <i class="bi bi-cash-stack text-primary"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value">Rp{{ number_format($totalRevenue,0,',','.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="dashboard-card-title">Pending Payments</div>
                        <div class="dashboard-card-icon bg-warning-light">
                            <i class="bi bi-clock-history text-warning"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value">{{ $pendingPayments }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="dashboard-card-title">Verified Payments</div>
                        <div class="dashboard-card-icon bg-success-light">
                            <i class="bi bi-check-circle text-success"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value">{{ $verifiedPayments }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="dashboard-card-title">Refunds</div>
                        <div class="dashboard-card-icon bg-danger-light">
                            <i class="bi bi-arrow-return-left text-danger"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value">{{ $refundPayments }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Payments Table -->
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Payments</h5>
                    <a href="{{ route('tim_keuangan.payments.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Session</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $reg)
                                    <tr>
                                        <td>{{ $reg->session->event->name ?? '-' }}</td>
                                        <td>{{ $reg->session->name ?? '-' }}</td>
                                        <td>{{ $reg->user->name ?? '-' }}</td>
                                        <td>Rp{{ number_format($reg->session->event->registration_fee ?? 0,0,',','.') }}</td>
                                        <td>
                                            @if($reg->payment_status == 1)
                                                <span class="badge bg-success">Verified</span>
                                            @elseif($reg->payment_status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($reg->payment_status == 2)
                                                <span class="badge bg-danger">Refund</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y') }}</td>
                                        <td>
                                            @if($reg->payment_status == 0)
                                                <!-- Tombol Lihat Bukti Pembayaran -->
                                                @if($reg->payment_proof_url)
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $reg->id }}">
                                                        <i class="bi bi-eye"></i> Lihat Bukti
                                                    </button>
                                                @endif
                                                <a href="{{ route('tim_keuangan.payments.verify', $reg->id) }}" class="btn btn-sm btn-outline-primary">Verify</a>
                                            @else
                                                <a href="{{ route('tim_keuangan.payments.show', $reg->id) }}" class="btn btn-sm btn-outline-secondary">Details</a>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Bukti Pembayaran -->
                                    @if($reg->payment_proof_url)
                                    <div class="modal fade" id="buktiModal{{ $reg->id }}" tabindex="-1" aria-labelledby="buktiModalLabel{{ $reg->id }}" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="buktiModalLabel{{ $reg->id }}">Bukti Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                          </div>
                                          <div class="modal-body text-center">
                                            @if(Str::endsWith(strtolower($reg->payment_proof_url), ['.jpg', '.jpeg', '.png']))
                                                <img src="{{ asset('storage/' . $reg->payment_proof_url) }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-2">
                                            @else
                                                <a href="{{ asset('storage/' . $reg->payment_proof_url) }}" target="_blank" class="btn btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                                </a>
                                            @endif
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection