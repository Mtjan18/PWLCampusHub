@extends('layouts.app')

@section('title', 'Committee Dashboard - UniEvent')

@section('content')
        <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
          <div class="col-12">
            <h2 class="dashboard-title">Event Committee Dashboard</h2>
            <p class="text-muted">Manage events, track attendance, and issue certificates in one place.</p>
          </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body d-flex flex-wrap gap-2">
                <a href="committee-events.html" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-2"></i> Create New Event
                </a>
                <a href="committee-attendance.html" class="btn btn-success">
                  <i class="bi bi-qr-code-scan me-2"></i> Scan Attendance
                </a>
                <a href="committee-certificates.html" class="btn btn-info text-white">
                  <i class="bi bi-upload me-2"></i> Upload Certificates
                </a>
                <a href="committee-reports.html" class="btn btn-secondary">
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
                  <div class="dashboard-card-title">Total Events</div>
                  <div class="dashboard-card-icon bg-primary-light">
                    <i class="bi bi-calendar-event text-primary"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">12</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">5 active, 7 completed</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">Total Registrations</div>
                  <div class="dashboard-card-icon bg-success-light">
                    <i class="bi bi-people text-success"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">354</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">+24 registrations this week</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">Attendance Rate</div>
                  <div class="dashboard-card-icon bg-warning-light">
                    <i class="bi bi-person-check text-warning"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">86%</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 86%" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">Across all events</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="dashboard-card-title">Revenue Generated</div>
                  <div class="dashboard-card-icon bg-info-light">
                    <i class="bi bi-cash-stack text-info"></i>
                  </div>
                </div>
                <div class="dashboard-card-value">$4,320</div>
                <div class="dashboard-card-progress">
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <div class="small mt-1">65% of the yearly target</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Active Events -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Active Events</h5>
                <a href="committee-events.html" class="btn btn-sm btn-primary">View All Events</a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Registrations</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="event-icon">
                              <i class="bi bi-laptop"></i>
                            </div>
                            <div>
                              <div class="fw-semibold">AI in Education Conference</div>
                              <div class="small text-muted">Main Auditorium</div>
                            </div>
                          </div>
                        </td>
                        <td>June 15, 2025<br><small class="text-muted">10:00 AM</small></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <span class="me-2">85/100</span>
                            <div class="progress" style="width: 80px; height: 6px;">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </td>
                        <td><span class="badge bg-success">Registration Open</span></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li><a class="dropdown-item" href="#">View Details</a></li>
                              <li><a class="dropdown-item" href="#">Edit Event</a></li>
                              <li><a class="dropdown-item" href="#">View Registrations</a></li>
                              <li><a class="dropdown-item" href="#">Close Registration</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="event-icon">
                              <i class="bi bi-person-workspace"></i>
                            </div>
                            <div>
                              <div class="fw-semibold">Leadership Development Workshop</div>
                              <div class="small text-muted">Business School</div>
                            </div>
                          </div>
                        </td>
                        <td>July 10, 2025<br><small class="text-muted">2:00 PM</small></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <span class="me-2">50/50</span>
                            <div class="progress" style="width: 80px; height: 6px;">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </td>
                        <td><span class="badge bg-danger">Fully Booked</span></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                              Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                              <li><a class="dropdown-item" href="#">View Details</a></li>
                              <li><a class="dropdown-item" href="#">Edit Event</a></li>
                              <li><a class="dropdown-item" href="#">View Registrations</a></li>
                              <li><a class="dropdown-item" href="#">Increase Capacity</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="event-icon">
                              <i class="bi bi-lightbulb"></i>
                            </div>
                            <div>
                              <div class="fw-semibold">Design Thinking in Research</div>
                              <div class="small text-muted">Innovation Hub</div>
                            </div>
                          </div>
                        </td>
                        <td>August 5, 2025<br><small class="text-muted">9:30 AM</small></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <span class="me-2">25/75</span>
                            <div class="progress" style="width: 80px; height: 6px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </td>
                        <td><span class="badge bg-primary">Registration Open</span></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                              Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                              <li><a class="dropdown-item" href="#">View Details</a></li>
                              <li><a class="dropdown-item" href="#">Edit Event</a></li>
                              <li><a class="dropdown-item" href="#">View Registrations</a></li>
                              <li><a class="dropdown-item" href="#">Close Registration</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Recent Activity and Upcoming Events -->
        <div class="row g-4">
          <!-- Recent Activity -->
          <div class="col-lg-7">
            <div class="card h-100">
              <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
              </div>
              <div class="card-body p-0">
                <div class="activity-timeline">
                  <div class="activity-item">
                    <div class="activity-icon bg-primary">
                      <i class="bi bi-person-plus text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">Today, 10:30 AM</div>
                      <div class="activity-text">5 new registrations for <strong>AI in Education Conference</strong></div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-success">
                      <i class="bi bi-check-circle text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">Yesterday, 2:15 PM</div>
                      <div class="activity-text">Updated event details for <strong>Leadership Development Workshop</strong></div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-info">
                      <i class="bi bi-upload text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">Yesterday, 11:45 AM</div>
                      <div class="activity-text">Uploaded 35 certificates for <strong>Web Development Bootcamp</strong></div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-warning">
                      <i class="bi bi-exclamation-circle text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">June 10, 2025, 9:20 AM</div>
                      <div class="activity-text"><strong>Leadership Development Workshop</strong> reached 90% capacity</div>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon bg-secondary">
                      <i class="bi bi-calendar-plus text-white"></i>
                    </div>
                    <div class="activity-content">
                      <div class="activity-time">June 9, 2025, 3:40 PM</div>
                      <div class="activity-text">Created new event: <strong>Annual Research Symposium</strong></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-end">
                <a href="#" class="btn btn-sm btn-primary">View All Activity</a>
              </div>
            </div>
          </div>
          
          <!-- Tasks & Reminders -->
          <div class="col-lg-5">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Tasks & Reminders</h5>
                <button class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-plus-circle"></i> Add Task
                </button>
              </div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="task1">
                      <label class="form-check-label" for="task1">
                        Upload certificates for Leadership Workshop
                        <div class="small text-danger">Due Today</div>
                      </label>
                    </div>
                    <div>
                      <button class="btn btn-sm btn-link text-secondary">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-link text-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="task2">
                      <label class="form-check-label" for="task2">
                        Confirm speaker details for AI Conference
                        <div class="small text-warning">Due Tomorrow</div>
                      </label>
                    </div>
                    <div>
                      <button class="btn btn-sm btn-link text-secondary">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-link text-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="task3" checked>
                      <label class="form-check-label text-decoration-line-through text-muted" for="task3">
                        Book auditorium for next month's seminar
                        <div class="small text-muted">Completed on Jun 10</div>
                      </label>
                    </div>
                    <div>
                      <button class="btn btn-sm btn-link text-secondary">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-link text-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="task4">
                      <label class="form-check-label" for="task4">
                        Prepare report for University Administration
                        <div class="small text-primary">Due in 3 days</div>
                      </label>
                    </div>
                    <div>
                      <button class="btn btn-sm btn-link text-secondary">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-link text-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="task5">
                      <label class="form-check-label" for="task5">
                        Finalize budget for Student Startup Competition
                        <div class="small text-primary">Due in 5 days</div>
                      </label>
                    </div>
                    <div>
                      <button class="btn btn-sm btn-link text-secondary">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-link text-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
