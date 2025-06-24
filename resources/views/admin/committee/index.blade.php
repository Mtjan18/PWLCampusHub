@extends('layouts.app')

@section('title', 'Committee Management - UniEvent Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header with Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Committee Management</h2>
            <p class="text-muted">Manage committee members for events and activities</p>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="{{ route('admin.members') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-plus"></i> Add New Committee
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

    <!-- Committee List with max-width container -->
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 1300px;">
        <div class="card-body">
            <div class="table-responsive">
                @if($committees->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted display-1"></i>
                        <p class="fs-5 mt-3">No committee members found</p>
                        <a href="{{ route('admin.members') }}" class="btn btn-primary mt-2">
                            Add Committee Members
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
                            @foreach($committees as $committee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary-light text-primary me-2">
                                                {{ substr($committee->name, 0, 1) }}
                                            </div>
                                            <div>{{ $committee->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $committee->email }}</td>
                                    <td>{{ $committee->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#removeCommitteeModal" 
                                               data-committee-id="{{ $committee->id }}"
                                               data-committee-name="{{ $committee->name }}">
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
    @if(isset($committees) && method_exists($committees, 'links') && $committees->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $committees->links() }}
        </div>
    @endif
</div>

<!-- Remove Committee Confirmation Modal -->
<div class="modal fade" id="removeCommitteeModal" tabindex="-1" aria-labelledby="removeCommitteeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="removeCommitteeModalLabel">Remove Committee Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-warning display-4"></i>
                </div>
                <p>Are you sure you want to remove <strong id="committeeNameText"></strong> from the committee team?</p>
                <p class="text-muted">This action will revert them to a regular member but won't delete their account.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="removeCommitteeForm" action="{{ route('admin.committee.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="committeeIdInput">
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
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.15);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle committee removal modal
        const removeModal = document.getElementById('removeCommitteeModal');
        if (removeModal) {
            removeModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract info from data attributes
                const committeeId = button.getAttribute('data-committee-id');
                const committeeName = button.getAttribute('data-committee-name');
                
                // Update the modal's content
                const modalCommitteeName = document.getElementById('committeeNameText');
                const modalCommitteeId = document.getElementById('committeeIdInput');
                
                modalCommitteeName.textContent = committeeName;
                modalCommitteeId.value = committeeId;
            });
        }
    });
</script>
@endsection