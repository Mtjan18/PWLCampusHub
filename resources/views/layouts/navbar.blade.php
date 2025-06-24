<nav class="navbar navbar-expand navbar-light bg-white topbar">
          <button class="btn btn-link d-lg-none" id="sidebarToggle">
              <i class="bi bi-list"></i>
          </button>

          <div class="navbar-nav ms-auto">
              @auth
                  @php $role = Auth::user()->role->name; @endphp
                  <div class="nav-item d-flex align-items-center me-3">
                      @if($role === 'admin')
                          <a class="nav-link text-primary fw-semibold" href="{{ route('admin.dashboard') }}">Dashboard</a>
                          <a class="nav-link text-primary fw-semibold ms-3" href="{{ route('admin.events') }}">Events</a>
                      @elseif($role === 'panitia')
                          <a class="nav-link text-primary fw-semibold" href="{{ route('panitia.dashboard') }}">Dashboard</a>
                          <a class="nav-link text-primary fw-semibold ms-3" href="{{ route('panitia.events.create') }}">Buat Event</a>
                      @elseif($role === 'tim_keuangan')
                          <a class="nav-link text-primary fw-semibold" href="{{ route('tim_keuangan.dashboard') }}">Dashboard</a>
                          <a class="nav-link text-primary fw-semibold ms-3" href="{{ route('tim_keuangan.payments.index') }}">Payments</a>
                      @elseif($role === 'member')
                          <a class="nav-link text-primary fw-semibold" href="{{ route('member.dashboard') }}">Dashboard</a>
                          <a class="nav-link text-primary fw-semibold ms-3" href="{{ route('events') }}">My Events</a>
                      @endif
                  </div>
                  <!-- User Profile Dropdown -->
                  <div class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <span class="d-none d-lg-inline text-gray-600 me-2">{{ Auth::user()->name }}</span>
                          <img class="rounded-circle" src="https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg"
                              alt="User Avatar" width="32" height="32">
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                          <a class="dropdown-item" href="#">
                              <i class="bi bi-person me-2 text-gray-400"></i>
                              Profile
                          </a>
                          <a class="dropdown-item" href="#">
                              <i class="bi bi-gear me-2 text-gray-400"></i>
                              Settings
                          </a>
                          <div class="dropdown-divider"></div>
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="dropdown-item">
                                  <i class="bi bi-box-arrow-right me-2 text-gray-400"></i>
                                  Logout
                              </button>
                          </form>
                      </div>
                  </div>
              @else
                  <a href="{{ url('/login') }}" class="btn btn-outline-primary me-2">Login</a>
                  <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
              @endauth
          </div>
      </nav>
