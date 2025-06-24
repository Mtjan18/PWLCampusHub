@extends('layouts.app')

@section('title', 'Payment Transactions - Finance Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Payment Transactions</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('tim_keuangan.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payments</li>
                </ol>
            </nav>
        </div>
        
        <div class="d-flex mt-3 mt-md-0">
            <a href="#" class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="bi bi-file-earmark-excel me-1"></i> Export
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
        </div>
    </div>

    <!-- Payment Status Pills -->
    <div class="payment-status-tabs mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item me-2">
                <a class="nav-link {{ request()->query('status') == null ? 'active' : '' }}" href="{{ route('tim_keuangan.payments.index') }}">
                    All Transactions
                    <span class="badge bg-light text-dark ms-1">{{ $totalTransactions }}</span>
                </a>
            </li>
            <li class="nav-item me-2">
                <a class="nav-link {{ request()->query('status') == 'pending' ? 'active' : '' }}" href="{{ route('tim_keuangan.payments.index', ['status' => 'pending']) }}">
                    Pending
                    <span class="badge bg-warning text-dark ms-1">{{ $pendingCount }}</span>
                </a>
            </li>
            <li class="nav-item me-2">
                <a class="nav-link {{ request()->query('status') == 'verified' ? 'active' : '' }}" href="{{ route('tim_keuangan.payments.index', ['status' => 'verified']) }}">
                    Verified
                    <span class="badge bg-success ms-1">{{ $verifiedCount }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->query('status') == 'refund' ? 'active' : '' }}" href="{{ route('tim_keuangan.payments.index', ['status' => 'refund']) }}">
                    Refunds
                    <span class="badge bg-danger ms-1">{{ $refundCount }}</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Active Filters -->
    @if(request()->query('status') || request()->query('event') || request()->query('date_from') || request()->query('date_to'))
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-2">
            <div class="d-flex align-items-center flex-wrap">
                <span class="me-3 text-muted">Active filters:</span>
                
                @if(request()->query('status'))
                <span class="badge bg-light text-dark me-2 mb-1">
                    Status: {{ ucfirst(request()->query('status')) }}
                    <a href="{{ route('tim_keuangan.payments.index', array_merge(request()->query(), ['status' => null])) }}" class="text-dark ms-1">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </span>
                @endif
                
                @if(request()->query('event'))
                <span class="badge bg-light text-dark me-2 mb-1">
                    Event: {{ \App\Models\Event::find(request()->query('event'))->name ?? 'Unknown' }}
                    <a href="{{ route('tim_keuangan.payments.index', array_merge(request()->query(), ['event' => null])) }}" class="text-dark ms-1">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </span>
                @endif
                
                @if(request()->query('date_from') || request()->query('date_to'))
                <span class="badge bg-light text-dark me-2 mb-1">
                    Date: {{ request()->query('date_from') ?? 'Any' }} to {{ request()->query('date_to') ?? 'Any' }}
                    <a href="{{ route('tim_keuangan.payments.index', array_merge(request()->query(), ['date_from' => null, 'date_to' => null])) }}" class="text-dark ms-1">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </span>
                @endif
                
                <a href="{{ route('tim_keuangan.payments.index') }}" class="btn btn-sm btn-outline-secondary ms-auto mb-1">
                    <i class="bi bi-x me-1"></i>Clear All
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Payments Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-3">ID</th>
                            <th scope="col">Event</th>
                            <th scope="col">User</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                        <tr class="{{ $registration->payment_status == 0 ? 'bg-light' : '' }}">
                            <td class="ps-3 fw-semibold text-primary">#{{ $registration->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="event-icon me-2 rounded p-1 {{ $registration->session && $registration->session->event ? 'bg-' . ['primary', 'success', 'warning', 'info', 'danger'][($registration->session->event->id % 5)] . '-light' : 'bg-secondary-light' }}">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $registration->session->event->name ?? 'Unknown Event' }}</div>
                                        <div class="small text-muted">{{ $registration->session->name ?? 'Unknown Session' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-light text-dark me-2">
                                        {{ substr($registration->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div>{{ $registration->user->name ?? 'Unknown User' }}</div>
                                        <div class="small text-muted">{{ $registration->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-semibold">
                                Rp{{ number_format($registration->session->fee ?? 0,0,',','.') }}
                            </td>
                            <td>
                                @if($registration->payment_status == 1)
                                    <div class="d-flex align-items-center">
                                        <span class="status-indicator bg-success me-2"></span>
                                        <span>Verified</span>
                                    </div>
                                @elseif($registration->payment_status == 0)
                                    <div class="d-flex align-items-center">
                                        <span class="status-indicator bg-warning me-2"></span>
                                        <span>Pending</span>
                                    </div>
                                @elseif($registration->payment_status == 2)
                                    <div class="d-flex align-items-center">
                                        <span class="status-indicator bg-danger me-2"></span>
                                        <span>Refund</span>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <span class="status-indicator bg-secondary me-2"></span>
                                        <span>Unknown</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($registration->registered_at)->format('M d, Y') }}</div>
                                <div class="small text-muted">{{ \Carbon\Carbon::parse($registration->registered_at)->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    @if($registration->payment_proof_url)
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#proofModal"
                                               data-payment-proof="{{ asset('storage/' . $registration->payment_proof_url) }}"
                                               data-reg-id="{{ $registration->id }}"
                                               data-event-name="{{ $registration->session->event->name ?? 'Event' }}"
                                               data-user-name="{{ $registration->user->name ?? 'User' }}">
                                            <i class="bi bi-image"></i> Proof
                                        </button>
                                    @endif
                                    
                                    @if($registration->payment_status == 0)
                                        <a href="{{ route('tim_keuangan.payments.verify', $registration->id) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check-circle"></i> Verify
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" data-reg-id="{{ $registration->id }}">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('tim_keuangan.payments.show', $registration->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-info-circle"></i> Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-credit-card text-muted display-6 mb-3 d-block"></i>
                                    <p class="mb-1 fw-semibold fs-5">No payment records found</p>
                                    <p class="text-muted">Try adjusting your filter criteria</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    Showing <span class="fw-semibold">{{ $registrations->firstItem() ?? 0 }}</span> to 
                    <span class="fw-semibold">{{ $registrations->lastItem() ?? 0 }}</span> of 
                    <span class="fw-semibold">{{ $registrations->total() }}</span> entries
                </div>
                <div>
                    {{ $registrations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mt-4">
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Amount</h6>
                    <h3 class="mb-0">Rp{{ number_format($totalAmount,0,',','.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Pending Payments</h6>
                    <h3 class="mb-0">Rp{{ number_format($pendingAmount,0,',','.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Average Payment</h6>
                    <h3 class="mb-0">Rp{{ number_format($averageAmount,0,',','.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Most Recent</h6>
                    <h3 class="mb-0">{{ $mostRecentDate ? \Carbon\Carbon::parse($mostRecentDate)->format('d M Y') : '-' }}</h3>
                </div>
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
            <div class="modal-body">
                <div class="payment-proof-details mb-3 p-3 bg-light rounded">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="small text-muted">Event</div>
                            <div class="fw-semibold" id="proofEventName">Event Name</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">User</div>
                            <div class="fw-semibold" id="proofUserName">User Name</div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <img id="paymentProofImage" src="" alt="Payment Proof" class="img-fluid rounded mb-3 shadow-sm">
                </div>
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
                        <select class="form-select mb-2" id="rejection_reason" name="rejection_reason">
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
                <button type="submit" form="rejectForm" class="btn btn-danger">Reject Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Transactions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm" action="{{ route('tim_keuangan.payments.index') }}" method="GET">
                    <div class="mb-3">
                        <label for="status" class="form-label">Payment Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request()->query('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request()->query('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="refund" {{ request()->query('status') == 'refund' ? 'selected' : '' }}>Refund</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="event" class="form-label">Event</label>
                        <select class="form-select" id="event" name="event">
                            <option value="">All Events</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request()->query('event') == $event->id ? 'selected' : '' }}>
                                    {{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request()->query('date_from') }}">
                                <label for="date_from" class="form-text">From</label>
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request()->query('date_to') }}">
                                <label for="date_to" class="form-text">To</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by event name, user..." value="{{ request()->query('search') }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="{{ route('tim_keuangan.payments.index') }}" class="btn btn-outline-secondary">Reset Filters</a>
                <button type="submit" form="filterForm" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Payment Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm" action="" method="GET">
                    <div class="mb-3">
                        <label for="export_format" class="form-label">Format</label>
                        <select class="form-select" id="export_format" name="format">
                            <option value="excel">Excel (.xlsx)</option>
                            <option value="csv">CSV (.csv)</option>
                            <option value="pdf">PDF (.pdf)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="export_current_filter" name="current_filter" checked>
                            <label class="form-check-label" for="export_current_filter">
                                Apply current filters
                            </label>
                            <div class="form-text">If checked, the export will include only the data matching your current filters.</div>
                        </div>
                    </div>
                    
                    <!-- Include current filters as hidden fields -->
                    @foreach(request()->query() as $key => $value)
                        @if(!in_array($key, ['page', 'per_page']))
                            <input type="hidden" name="filters[{{ $key }}]" value="{{ $value }}">
                        @endif
                    @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="exportForm" class="btn btn-success">
                    <i class="bi bi-download me-1"></i> Export Data
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Status indicator dot */
    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    
    /* Avatar circle */
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    /* Event icon */
    .event-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Color light variants */
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.15); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.15); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.15); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.15); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.15); }
    .bg-secondary-light { background-color: rgba(108, 117, 125, 0.15); }
    
    /* Pagination styling */
    .pagination {
        margin-bottom: 0;
    }
    
    /* Payment status tabs */
    .payment-status-tabs .nav-link {
        border-radius: 50rem;
        padding: 0.5rem 1rem;
    }
    
    .payment-status-tabs .nav-link:not(.active) {
        color: #212529;
        background-color: #f8f9fa;
    }
    
    /* Hover effect for rows */
    .table tr:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment proof modal
    const proofModal = document.getElementById('proofModal');
    const paymentProofImage = document.getElementById('paymentProofImage');
    const verifyPaymentBtn = document.getElementById('verifyPaymentBtn');
    const proofEventName = document.getElementById('proofEventName');
    const proofUserName = document.getElementById('proofUserName');
    
    if (proofModal) {
        proofModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const paymentProofUrl = button.getAttribute('data-payment-proof');
            const regId = button.getAttribute('data-reg-id');
            const eventName = button.getAttribute('data-event-name');
            const userName = button.getAttribute('data-user-name');
            
            paymentProofImage.src = paymentProofUrl;
            verifyPaymentBtn.href = `/tim-keuangan/payments/${regId}/verify`;
            proofEventName.textContent = eventName;
            proofUserName.textContent = userName;
        });
    }
    
    // Reject modal
    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');
    
    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const regId = button.getAttribute('data-reg-id');
            
            rejectForm.action = `/tim-keuangan/payments/${regId}/reject`;
        });
    }
});
</script>
@endsection