@extends('layouts.app')

@section('title', 'Member Dashboard - UniEvent')

@section('content')
    <!-- Dashboard Content -->
    <div class="container-fluid px-4 py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="dashboard-title">Member Dashboard</h2>
                <p class="text-muted">Welcome back, Emma! Here's an overview of your events and activities.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Registered Events</div>
                            <div class="dashboard-card-icon bg-primary-light">
                                <i class="bi bi-calendar2-check text-primary"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">5</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">3 upcoming, 2 completed</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Certificates</div>
                            <div class="dashboard-card-icon bg-success-light">
                                <i class="bi bi-award text-success"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">3</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%"
                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">3 earned, 2 pending</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Payments</div>
                            <div class="dashboard-card-icon bg-warning-light">
                                <i class="bi bi-credit-card text-warning"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">$45</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 80%"
                                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">Total spent on events</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="dashboard-card-title">Attendance</div>
                            <div class="dashboard-card-icon bg-info-light">
                                <i class="bi bi-person-check text-info"></i>
                            </div>
                        </div>
                        <div class="dashboard-card-value">2/2</div>
                        <div class="dashboard-card-progress">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="small mt-1">Perfect attendance rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Upcoming Events</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Payment Status</th>
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
                                                    <div class="small text-muted">Technology</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>June 15, 2025<br><small class="text-muted">10:00 AM</small></td>
                                        <td>Main Auditorium</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Show QR Code</a></li>
                                                    <li><a class="dropdown-item" href="#">Cancel Registration</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="event-icon">
                                                    <i class="bi bi-graph-up"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">Annual Research Symposium</div>
                                                    <div class="small text-muted">Science</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>September 12, 2025<br><small class="text-muted">8:00 AM</small></td>
                                        <td>Science Complex</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Upload Payment</a></li>
                                                    <li><a class="dropdown-item" href="#">Cancel Registration</a>
                                                    </li>
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
                                                    <div class="fw-semibold">Student Startup Competition</div>
                                                    <div class="small text-muted">Business</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>October 20, 2025<br><small class="text-muted">1:00 PM</small></td>
                                        <td>Entrepreneurship Center</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Show QR Code</a></li>
                                                    <li><a class="dropdown-item" href="#">Cancel Registration</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="member-events.html" class="btn btn-sm btn-primary">View All Events</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Certificates and Payment History -->
        <div class="row g-4">
            <!-- Latest Certificates -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Latest Certificates</h5>
                        <a href="member-certificates.html" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="certificate-item">
                            <div class="certificate-preview">
                                <img src="https://images.pexels.com/photos/5428826/pexels-photo-5428826.jpeg"
                                    alt="Certificate">
                                <a href="#" class="certificate-download">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                            <div class="certificate-details">
                                <h6 class="mb-1">Leadership Development Workshop</h6>
                                <div class="text-muted small">Issued on: April 15, 2025</div>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary ms-1">Share</a>
                                </div>
                            </div>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-preview">
                                <img src="https://images.pexels.com/photos/5428826/pexels-photo-5428826.jpeg"
                                    alt="Certificate">
                                <a href="#" class="certificate-download">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                            <div class="certificate-details">
                                <h6 class="mb-1">Web Development Bootcamp</h6>
                                <div class="text-muted small">Issued on: March 20, 2025</div>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary ms-1">Share</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Payments</h5>
                        <a href="member-payments.html" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>AI in Education Conference</td>
                                        <td>May 5, 2025</td>
                                        <td>$25.00</td>
                                        <td><span class="badge bg-success">Confirmed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Student Startup Competition</td>
                                        <td>May 1, 2025</td>
                                        <td>$10.00</td>
                                        <td><span class="badge bg-success">Confirmed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Annual Research Symposium</td>
                                        <td>April 28, 2025</td>
                                        <td>$5.00</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>Leadership Development Workshop</td>
                                        <td>April 10, 2025</td>
                                        <td>$15.00</td>
                                        <td><span class="badge bg-success">Confirmed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
