@extends('layouts.app')

@section('title', 'Admin Dashboard - CampusHub')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="dashboard-title mb-1"><i class="bi bi-speedometer2 me-2"></i> Administrator Dashboard</h2>
            <p class="text-muted">Kelola panitia, tim keuangan, dan pengguna dengan mudah.</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex flex-wrap gap-3">
                    <a href="{{ route('admin.members') }}" class="btn btn-lg btn-outline-primary d-flex align-items-center gap-2">
                        <i class="bi bi-person-lines-fill fs-4"></i>
                        <span>Lihat Semua Member</span>
                    </a>
                    <a href="{{ route('admin.committee.index') }}" class="btn btn-lg btn-outline-info d-flex align-items-center gap-2">
                        <i class="bi bi-people-fill fs-4"></i>
                        <span>Kelola Panitia</span>
                    </a>
                    <a href="{{ route('admin.finance.index') }}" class="btn btn-lg btn-outline-success d-flex align-items-center gap-2">
                        <i class="bi bi-cash-coin fs-4"></i>
                        <span>Kelola Tim Keuangan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 animate__fadeInUp">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dashboard-card-title">Total Member</div>
                        <div class="dashboard-card-icon bg-primary-light">
                            <i class="bi bi-people text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value fs-2">{{ $totalMembers ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 animate__fadeInUp">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dashboard-card-title">Panitia Aktif</div>
                        <div class="dashboard-card-icon bg-info-light">
                            <i class="bi bi-people-fill text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value fs-2">{{ $totalCommittee ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 animate__fadeInUp">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="dashboard-card-title">Tim Keuangan Aktif</div>
                        <div class="dashboard-card-icon bg-success-light">
                            <i class="bi bi-cash-coin text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="dashboard-card-value fs-2">{{ $totalFinance ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities (Optional, uncomment if available) -->
    {{-- 
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0"><i class="bi bi-clock-history me-2"></i> Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentActivities as $activity)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>{!! $activity->description !!}</span>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">Belum ada aktivitas terbaru.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.activities') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>
    --}}
</div>
@endsection
