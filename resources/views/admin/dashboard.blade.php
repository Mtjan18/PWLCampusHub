@extends('layouts.app')

@section('title', 'Admin Dashboard - CampusHub')

@section('content')
      <!-- Dashboard Content -->
      <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
          <div class="col-12">
            <h2 class="dashboard-title">Administrator Dashboard</h2>
            <p class="text-muted">Manage users, teams, and system settings</p>
          </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body d-flex flex-wrap gap-2">
                <a href="admin-users.html" class="btn btn-primary">
                  <i class="bi bi-person-plus me-2"></i> Add New User
                </a>
                <a href="admin-finance.html" class="btn btn-success">
                  <i class="bi bi-cash me-2"></i> Manage Finance Team
                </a>
                <a href="admin-committee.html" class="btn btn-info text-white">
                  <i class="bi bi-people me-2"></i> Manage Committee
                </a>
                <a href="admin-reports.html" class="btn btn-secondary">
                  <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">Total Users</div>
                  <div class="dashboard-card-icon bg-primary-light">
                    <i class="bi bi-people text-primary"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">1,234</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">+15% from last month</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">Active Events</div>
                  <div class="dashboard-card-icon bg-success-light">
                    <i class="bi bi-calendar-check text-success"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">42</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">28 upcoming, 14 ongoing</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">System Load</div>
                  <div class="dashboard-card-icon bg-warning-light">
                    <i class="bi bi-cpu text-warning"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">65%</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">Normal operating range</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">Storage Used</div>
                  <div class="dashboard-card-icon bg-info-light">
                    <i class="bi bi-hdd text-info"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">75%</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">750GB of 1TB used</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Recent Activities and System Status -->
        <div class="row g-4">
          <!-- Recent Activities -->
          <div class="col-lg-8">
            <div class="card h-100">
              <div class="card-header">
                <h5 class="card-title mb-0">Recent Activities</h5>
              </div>
              <div class="card-body p-0">
                <div class="activity-timeline">
                  <div class="activity-item">
                    <div class="activity-icon bg-primary">
                      <i class="bi bi-person-plus text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">Today, 10:30 AM</div>
                      <div class="activity-text">New finance team member <strong>Sarah Johnson</strong> added</div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-success">
                      <i class="bi bi-check-circle text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">Yesterday, 2:15 PM</div>
                      <div class="activity-text">System backup completed successfully</div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-warning">
                      <i class="bi bi-exclamation-triangle text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">Yesterday, 11:45 AM</div>
                      <div class="activity-text">High server load detected - optimizations applied</div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-info">
                      <i class="bi bi-gear text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">June 10, 2025, 9:20 AM</div>
                      <div class="activity-text">System settings updated by admin</div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-danger">
                      <i class="bi bi-trash text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">June 9, 2025, 3:40 PM</div>
                      <div class="activity-text">Inactive user accounts cleaned up</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-end">
                <a href="#" class="btn btn-sm btn-primary">View All Activities</a>
              </div>
            </div>
          </div>
          
          <!-- System Status -->
          <div class="col-lg-4">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">System Status</h5>
                <button class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
              </div>
              <div class="card-body">
                <div class="mb-4">
                  <div class="d-flex justify-content-between mb-2">
                    <span>CPU Usage</span>
                    <span class="text-primary">65%</span>
                  </div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Memory Usage</span>
                    <span class="text-success">45%</span>
                  </div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Storage Usage</span>
                    <span class="text-warning">75%</span>
                  </div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Network Load</span>
                    <span class="text-info">35%</span>
                  </div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                
                <div class="mt-4">
                  <h6 class="fw-bold mb-3">Service Status</h6>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Web Server</span>
                    <span class="badge bg-success">Operational</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Database</span>
                    <span class="badge bg-success">Operational</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Email Service</span>
                    <span class="badge bg-success">Operational</span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <span>Storage Service</span>
                    <span class="badge bg-warning">Degraded</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

@endsection