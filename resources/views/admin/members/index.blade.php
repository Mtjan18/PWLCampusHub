@extends('layouts.app')

@section('title', 'Member Management - UniEvent Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Member Management</h2>
            <p class="text-muted">Manage registered members and assign roles</p>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
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

    <!-- Members List -->
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 1000px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                @if($members->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted display-1"></i>
                        <p class="fs-5 mt-3">No members found</p>
                    </div>
                @else
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Member Since</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary-light text-primary me-2">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            <div>{{ $member->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-person-badge"></i> Assign Role
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#promoteModal" 
                                                        data-user-id="{{ $member->id }}" data-user-name="{{ $member->name }}" data-role-id="4" data-role-name="Committee Member">
                                                            <i class="bi bi-person-plus text-primary"></i> Make Committee Member
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#promoteModal" 
                                                        data-user-id="{{ $member->id }}" data-user-name="{{ $member->name }}" data-role-id="3" data-role-name="Finance Team Member">
                                                            <i class="bi bi-cash-coin text-success"></i> Make Finance Team Member
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($members) && method_exists($members, 'links') && $members->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $members->links() }}
        </div>
    @endif
</div>

<!-- Promote Member Modal -->
<div class="modal fade" id="promoteModal" tabindex="-1" aria-labelledby="promoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="promoteModalLabel">Promote Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i id="roleIcon" class="bi bi-person-badge-fill text-primary display-4"></i>
                </div>
                <p>Are you sure you want to promote <strong id="memberNameText"></strong> to <strong id="roleNameText"></strong>?</p>
                <p class="text-muted">This member will gain additional permissions according to their new role.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="promoteForm" action="{{ route('admin.members.promote') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="memberIdInput">
                    <input type="hidden" name="new_role_id" id="roleIdInput">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-fill-up"></i> Promote Member
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
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.15);
    }
    .table th, .table td {
        padding: 0.75rem 1rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Handle member promotion modal
    const promoteModal = document.getElementById('promoteModal');
    if (promoteModal) {
        promoteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const roleId = button.getAttribute('data-role-id');
            const roleName = button.getAttribute('data-role-name');
            
            // Update the modal's content
            document.getElementById('memberNameText').textContent = userName;
            document.getElementById('roleNameText').textContent = roleName;
            document.getElementById('memberIdInput').value = userId;
            document.getElementById('roleIdInput').value = roleId;
            
            // Update icon based on role
            const roleIcon = document.getElementById('roleIcon');
            if (roleId == 3) { // Finance Team
                roleIcon.className = 'bi bi-cash-coin text-success display-4';
            } else if (roleId == 4) { // Committee
                roleIcon.className = 'bi bi-person-badge-fill text-primary display-4';
            }
        });
    }
});
</script>
@endsection