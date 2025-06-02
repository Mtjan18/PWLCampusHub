      <nav class="navbar navbar-expand navbar-light bg-white topbar">
          <button class="btn btn-link d-lg-none" id="sidebarToggle">
              <i class="bi bi-list"></i>
          </button>

          <div class="navbar-nav ms-auto">
              <!-- Tambahan link Dashboard dan Events -->
              <div class="nav-item d-flex align-items-center me-3">
                  <a class="nav-link text-primary fw-semibold" href="dashboard.html">Dashboard</a>
                  <a class="nav-link text-primary fw-semibold ms-3" href="events.html">Events</a>
              </div>

              <!-- Notifikasi -->
              <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-bell"></i>
                      <span class="badge bg-danger">3</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end notification-dropdown"
                      aria-labelledby="notificationsDropdown">
                      <h6 class="dropdown-header">Notifications</h6>
                      <a class="dropdown-item d-flex align-items-center" href="#">
                          <div class="me-3">
                              <div class="notification-icon bg-primary">
                                  <i class="bi bi-calendar-check text-white"></i>
                              </div>
                          </div>
                          <div>
                              <div class="small text-gray-500">June 12, 2025</div>
                              <span>Your registration for "AI in Education" has been confirmed!</span>
                          </div>
                      </a>
                      <a class="dropdown-item d-flex align-items-center" href="#">
                          <div class="me-3">
                              <div class="notification-icon bg-success">
                                  <i class="bi bi-cash-coin text-white"></i>
                              </div>
                          </div>
                          <div>
                              <div class="small text-gray-500">June 10, 2025</div>
                              <span>Your payment for "Research Symposium" was received.</span>
                          </div>
                      </a>
                      <a class="dropdown-item d-flex align-items-center" href="#">
                          <div class="me-3">
                              <div class="notification-icon bg-warning">
                                  <i class="bi bi-award text-white"></i>
                              </div>
                          </div>
                          <div>
                              <div class="small text-gray-500">June 8, 2025</div>
                              <span>New certificate available: "Leadership Workshop"</span>
                          </div>
                      </a>
                      <a class="dropdown-item text-center small text-gray-500" href="#">Show All Notifications</a>
                  </div>
              </div>

              <!-- User Profile -->
              <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="d-none d-lg-inline text-gray-600 me-2">Emma Johnson</span>
                      <img class="rounded-circle" src="https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg"
                          alt="User Avatar" width="32" height="32">
                  </a>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                      <a class="dropdown-item" href="member-profile.html">
                          <i class="bi bi-person me-2 text-gray-400"></i>
                          Profile
                      </a>
                      <a class="dropdown-item" href="#">
                          <i class="bi bi-gear me-2 text-gray-400"></i>
                          Settings
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#" id="logoutBtn">
                          <i class="bi bi-box-arrow-right me-2 text-gray-400"></i>
                          Logout
                      </a>
                  </div>
              </div>
          </div>
      </nav>
