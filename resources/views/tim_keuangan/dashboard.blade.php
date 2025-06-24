@extends('layouts.app')

@section('title', 'Finance Dashboard - UniEvent')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Banner -->
    <div class="finance-welcome-banner card border-0 mb-4">
        <div class="card-body py-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h2 class="text-white fw-bold mb-1">Finance Dashboard</h2>
                    <p class="text-white opacity-75 mb-0">Monitor payment activities and manage financial transactions</p>
                </div>
                <div class="col-md-5 d-none d-md-block text-end">
                    <div class="finance-welcome-graphic">
                        <i class="bi bi-graph-up-arrow"></i>
                        <i class="bi bi-cash-coin"></i>
                        <i class="bi bi-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 finance-stat-card revenue-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="finance-card-icon bg-success-light me-3">
                            <i class="bi bi-cash-stack text-success"></i>
                        </div>
                        <h5 class="card-title mb-0">Total Revenue</h5>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="mb-0 me-2">Rp{{ number_format($totalRevenue,0,',','.') }}</h2>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 finance-stat-card pending-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="finance-card-icon bg-warning-light me-3">
                            <i class="bi bi-clock-history text-warning"></i>
                        </div>
                        <h5 class="card-title mb-0">Pending Payments</h5>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="mb-0 me-2">{{ $pendingPayments }}</h2>
                        <span class="badge bg-warning text-dark">Requires Action</span>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ min(100, $pendingPayments * 5) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 finance-stat-card verified-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="finance-card-icon bg-primary-light me-3">
                            <i class="bi bi-check-circle text-primary"></i>
                        </div>
                        <h5 class="card-title mb-0">Verified Payments</h5>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="mb-0 me-2">{{ $verifiedPayments }}</h2>
                        <span class="text-success"><i class="bi bi-arrow-up"></i> Complete</span>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" 
                            style="width: {{ $verifiedPayments + $pendingPayments > 0 ? ($verifiedPayments / ($verifiedPayments + $pendingPayments) * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100 finance-stat-card refund-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="finance-card-icon bg-danger-light me-3">
                            <i class="bi bi-arrow-return-left text-danger"></i>
                        </div>
                        <h5 class="card-title mb-0">Refunds</h5>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <h2 class="mb-0 me-2">{{ $refundPayments }}</h2>
                        <span class="text-muted">Processed</span>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ min(100, $refundPayments * 5) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex gap-3 flex-wrap">
                    <a href="{{ route('tim_keuangan.payments.index') }}" class="btn btn-primary">
                        <i class="bi bi-list-check me-2"></i> All Transactions
                    </a>
                    @if($pendingPayments > 0)
                        <a href="{{ route('tim_keuangan.payments.index') }}?status=pending" class="btn btn-warning">
                            <i class="bi bi-hourglass-split me-2"></i> Review Pending ({{ $pendingPayments }})
                        </a>
                    @endif
                    <a href="#reports" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reportsModal">
                        <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="card-title mb-0">
                <i class="bi bi-clock-history text-primary me-2"></i>Recent Payments
            </h5>
            <a href="{{ route('tim_keuangan.payments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $reg)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $reg->session->event->name ?? '-' }}</div>
                                    <div class="small text-muted">{{ $reg->session->name ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-light text-dark me-2">
                                            {{ substr($reg->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div>{{ $reg->user->name ?? '-' }}</div>
                                    </div>
                                </td>
                                <td class="fw-semibold">Rp{{ number_format($reg->session->fee ?? 0,0,',','.') }}</td>
                                <td>
                                    @if($reg->payment_status == 1)
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Verified</span>
                                    @elseif($reg->payment_status == 0)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending</span>
                                    @elseif($reg->payment_status == 2)
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Refund</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($reg->registered_at)->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        @if($reg->payment_proof_url)
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#proofModal"
                                                    data-payment-proof="{{ asset('storage/' . $reg->payment_proof_url) }}"
                                                    data-reg-id="{{ $reg->id }}">
                                                <i class="bi bi-image"></i> Proof
                                            </button>
                                        @endif
                                        
                                        @if($reg->payment_status == 0)
                                            <a href="{{ route('tim_keuangan.payments.verify', $reg->id) }}" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-check-circle"></i> Verify
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal"
                                                data-reg-id="{{ $reg->id }}">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        @else
                                            <a href="{{ route('tim_keuangan.payments.show', $reg->id) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-info-circle"></i> Details
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-wallet2 display-6 mb-3 d-block"></i>
                                    <p class="mb-0">No payment records found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Payment Proof Modal -->
<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proofModalLabel">Payment Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="paymentProofImage" src="" alt="Payment Proof" class="img-fluid rounded mb-3 shadow-sm">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="verifyPaymentBtn" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Verify Payment
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Reports Modal -->
<div class="modal fade" id="reportsModal" tabindex="-1" aria-labelledby="reportsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportsModalLabel">Generate Financial Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <div class="mb-3">
                        <label for="reportType" class="form-label">Report Type</label>
                        <select class="form-select" id="reportType" required>
                            <option value="daily">Daily Summary</option>
                            <option value="weekly">Weekly Summary</option>
                            <option value="monthly">Monthly Summary</option>
                            <option value="custom">Custom Date Range</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reportFormat" class="form-label">Format</label>
                        <select class="form-select" id="reportFormat" required>
                            <option value="pdf">PDF Document</option>
                            <option value="excel">Excel Spreadsheet</option>
                            <option value="csv">CSV File</option>
                        </select>
                    </div>
                    
                    <div class="mb-3 date-range" style="display: none;">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="col-6">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                        <select class="form-select mb-2" id="rejection_reason" name="rejection_reason" required>
                            <option value="Invalid proof of payment">Invalid proof of payment</option>
                            <option value="Insufficient amount">Insufficient amount</option>
                            <option value="Payment from unauthorized source">Payment from unauthorized source</option>
                            <option value="Duplicate payment">Duplicate payment</option>
                            <option value="Other reason">Other reason</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rejection_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="rejection_notes" name="rejection_notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="rejectForm" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i> Reject Payment
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Finance Dashboard Styles */
    .finance-welcome-banner {
        background: linear-gradient(45deg, #1b5e20, #4caf50);
        border-radius: 15px;
    }
    
    .finance-welcome-graphic {
        position: relative;
    }
    
    .finance-welcome-graphic i {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.5);
        position: absolute;
    }
    
    .finance-welcome-graphic i:nth-child(1) {
        top: -30px;
        right: 20px;
        transform: rotate(15deg);
    }
    
    .finance-welcome-graphic i:nth-child(2) {
        top: -10px;
        right: 80px;
    }
    
    .finance-welcome-graphic i:nth-child(3) {
        top: 10px;
        right: 30px;
        transform: rotate(-15deg);
    }
    
    .finance-stat-card {
        border-radius: 12px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .finance-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .finance-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .revenue-card {
        border-bottom: 3px solid #198754;
    }
    
    .pending-card {
        border-bottom: 3px solid #ffc107;
    }
    
    .verified-card {
        border-bottom: 3px solid #0d6efd;
    }
    
    .refund-card {
        border-bottom: 3px solid #dc3545;
    }
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.15);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.15);
    }
    
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.15);
    }
    
    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.15);
    }
    
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment proof modal
    const proofModal = document.getElementById('proofModal');
    const paymentProofImage = document.getElementById('paymentProofImage');
    const verifyPaymentBtn = document.getElementById('verifyPaymentBtn');
    
    if (proofModal) {
        proofModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const paymentProofUrl = button.getAttribute('data-payment-proof');
            const regId = button.getAttribute('data-reg-id');
            
            paymentProofImage.src = paymentProofUrl;
            verifyPaymentBtn.href = `/tim-keuangan/payments/${regId}/verify`;
        });
    }
    
    // Custom date range for reports
    const reportType = document.getElementById('reportType');
    const dateRange = document.querySelector('.date-range');
    
    if (reportType) {
        reportType.addEventListener('change', function() {
            if (this.value === 'custom') {
                dateRange.style.display = 'block';
            } else {
                dateRange.style.display = 'none';
            }
        });
    }

    // Reject payment modal
    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');
    if (rejectModal && rejectForm) {
        rejectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const regId = button.getAttribute('data-reg-id');
            rejectForm.action = `/tim-keuangan/payments/${regId}/reject`;
        });
    }
});
</script>
@endsection