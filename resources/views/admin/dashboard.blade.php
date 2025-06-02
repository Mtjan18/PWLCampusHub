@extends('layouts.app')

@section('title', 'Admin Dashboard - CampusHub')

@section('content')
<div class="container-fluid px-4 py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="dashboard-title">Administrator Dashboard</h2>
      <p class="text-muted">Kelola panitia, tim keuangan, dan pengguna</p>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body d-flex flex-wrap gap-2">
          <a href="{{ route('admin.members') }}" class="btn btn-primary">
            <i class="bi bi-person-lines-fill me-2"></i> Lihat Semua Member
          </a>
          <a href="{{ route('admin.committee.index') }}" class="btn btn-info text-white">
            <i class="bi bi-people-fill me-2"></i> Kelola Panitia
          </a>
          <a href="{{ route('admin.finance.index') }}" class="btn btn-success">
            <i class="bi bi-cash-coin me-2"></i> Kelola Tim Keuangan
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-4">
      <div class="card dashboard-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="dashboard-card-title">Total Member</div>
            <div class="dashboard-card-icon bg-primary-light">
              <i class="bi bi-people text-primary"></i>
            </div>
          </div>
          <div class="dashboard-card-value">{{ $totalMembers ?? 0 }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="card dashboard-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="dashboard-card-title">Panitia Aktif</div>
            <div class="dashboard-card-icon bg-info-light">
              <i class="bi bi-people-fill text-info"></i>
            </div>
          </div>
          <div class="dashboard-card-value">{{ $totalCommittee ?? 0 }}</div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-4">
      <div class="card dashboard-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="dashboard-card-title">Tim Keuangan Aktif</div>
            <div class="dashboard-card-icon bg-success-light">
              <i class="bi bi-cash-coin text-success"></i>
            </div>
          </div>
          <div class="dashboard-card-value">{{ $totalFinance ?? 0 }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activities -->
  {{-- <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
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
  </div> --}}
</div>
@endsection
