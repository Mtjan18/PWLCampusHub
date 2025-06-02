@extends('layouts.app')

@section('title', 'Finance Team Management - Admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Finance Team Management</h2>
    
    <div class="mb-3">
        <a href="{{ route('admin.members') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Members
        </a>
        <a href="#" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Add Finance Member
        </a>
    </div>

    @if($financeTeam->count())
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Joined At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($financeTeam as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Remove</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-info">No finance team members found.</div>
    @endif
</div>
@endsection
