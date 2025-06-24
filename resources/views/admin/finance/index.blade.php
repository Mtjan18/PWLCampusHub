@extends('layouts.app')

@section('title', 'Finance Team Management - UniEvent Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-cash-coin text-success me-2"></i>Finance Team Management</h2>
            <p class="text-muted">Manage finance team members who verify payments and handle financial transactions</p>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="{{ route('admin.members') }}" class="btn btn-outline-success">
                <i class="bi bi-person-plus"></i> Add Finance Member
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Status Messages -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Finance Team List -->
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 1000px;">
        <div class="card-body">
            <div class="table-responsive">
                @if($financeTeam->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-cash-coin text-muted display-1"></i>
                        <p class="fs-5 mt-3">No finance team members found</p>
                        <a href="{{ route('admin.members') }}" class="btn btn-success mt-2">
                            Add Finance Team Members
                        </a>
                    </div>
                @else
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Joined Date</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financeTeam as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-success-light text-success me-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#removeFinanceModal" 
                                               data-user-id="{{ $user->id }}"
                                               data-user-name="{{ $user->name }}">
                                            <i class="bi bi-person-x"></i> Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Pagination (if needed) -->
    @if(isset($financeTeam) && method_exists($financeTeam, 'links') && $financeTeam->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $financeTeam->links() }}
        </div>
    @endif
</div>

<!-- Remove Finance Team Member Confirmation Modal -->
<div class="modal fade" id="removeFinanceModal" tabindex="-1" aria-labelledby="removeFinanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="removeFinanceModalLabel">Remove Finance Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-warning display-4"></i>
                </div>
                <p>Are you sure you want to remove <strong id="financeNameText"></strong> from the finance team?</p>
                <p class="text-muted">This action will revert them to a regular member but won't delete their account.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="removeFinanceForm" action="{{ route('admin.finance.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="financeIdInput">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-person-x"></i> Remove Member
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.15);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle finance member removal modal
        const removeModal = document.getElementById('removeFinanceModal');
        if (removeModal) {
            removeModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract info from data attributes
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                
                // Update the modal's content
                const modalUserName = document.getElementById('financeNameText');
                const modalUserId = document.getElementById('financeIdInput');
                
                modalUserName.textContent = userName;
                modalUserId.value = userId;
            });
        }
    });
</script>
@endsection