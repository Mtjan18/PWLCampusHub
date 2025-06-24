<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Events - UniEvent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet" />
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
  <style>
    /* Additional Styles for Events Page */
    .event-filter {
      background-color: #f8f9fa;
      border-radius: 0.375rem;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }
    .form-select, .form-control {
      border-radius: 0.25rem;
    }
    .page-title {
      color: #0d6efd;
      position: relative;
      display: inline-block;
      margin-bottom: 1.5rem;
      font-weight: 700;
    }
    .page-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 60px;
      height: 3px;
      background-color: #6c757d;
      border-radius: 3px;
    }
    .event-status {
      position: absolute;
      top: 1rem;
      left: 1rem;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.25rem 0.75rem;
      border-radius: 0.25rem;
      z-index: 2;
    }
    .status-open {
      background-color: #198754;
      color: white;
    }
    .status-full {
      background-color: #dc3545;
      color: white;
    }
    .status-upcoming {
      background-color: #ffc107;
      color: #212529;
    }
    .event-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin: 1rem 0;
      font-size: 0.9rem;
      color: #6c757d;
    }
    .event-meta-item {
      display: flex;
      align-items: center;
    }
    .event-meta-item i {
      color: #0d6efd;
      margin-right: 0.5rem;
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <i class="bi bi-calendar-event-fill me-2"></i>
        <span>CampusHub</span>
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/events') }}">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/about') }}">About</a>
          </li>
        </ul>
        <div class="d-flex">
          @guest
            <a href="{{ url('/login') }}" class="btn btn-outline-light me-2">Login</a>
            <a href="{{ url('/register') }}" class="btn btn-light">Register</a>
          @else
            <div class="dropdown">
              <a class="btn btn-light dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('member.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li><a class="dropdown-item" href="{{ route('member.events') }}"><i class="bi bi-calendar-event me-2"></i> My Events</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  <!-- Events Header -->
  <section class="page-header bg-light py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="page-title">University Events</h1>
          <p class="lead text-muted">Browse and register for upcoming events at the university</p>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0">
          <form action="{{ url('/events') }}" method="GET" class="w-100" role="search">
            <div class="input-group">
              <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search events..."
                value="{{ request('search') }}"
                aria-label="Search events"
              />
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Events Content -->
  <section class="events-section py-5">
    <div class="container">
      <!-- Filters -->
      <form action="{{ url('/events') }}" method="GET" class="event-filter">
        <div class="row g-3">
          <div class="col-md-3">
            <label for="categoryFilter" class="form-label">Category</label>
            <select id="categoryFilter" name="category" class="form-select">
              <option value="">All Categories</option>
              <option value="technology" {{ request('category') == 'technology' ? 'selected' : '' }}>Technology</option>
              <option value="business" {{ request('category') == 'business' ? 'selected' : '' }}>Business</option>
              <option value="science" {{ request('category') == 'science' ? 'selected' : '' }}>Science</option>
              <option value="arts" {{ request('category') == 'arts' ? 'selected' : '' }}>Arts</option>
              <option value="workshop" {{ request('category') == 'workshop' ? 'selected' : '' }}>Workshop</option>
              <option value="seminar" {{ request('category') == 'seminar' ? 'selected' : '' }}>Seminar</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="dateFilter" class="form-label">Date</label>
            <select id="dateFilter" name="date" class="form-select">
              <option value="">All Dates</option>
              <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Today</option>
              <option value="tomorrow" {{ request('date') == 'tomorrow' ? 'selected' : '' }}>Tomorrow</option>
              <option value="this-week" {{ request('date') == 'this-week' ? 'selected' : '' }}>This Week</option>
              <option value="this-month" {{ request('date') == 'this-month' ? 'selected' : '' }}>This Month</option>
              <option value="next-month" {{ request('date') == 'next-month' ? 'selected' : '' }}>Next Month</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="statusFilter" class="form-label">Status</label>
            <select id="statusFilter" name="status" class="form-select">
              <option value="">All Status</option>
              <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Registration Open</option>
              <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Fully Booked</option>
              <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            </select>
          </div>
          <div class="col-md-3 d-flex align-items-end justify-content-end gap-2">
            <a href="{{ url('/events') }}" class="btn btn-outline-secondary">
              <i class="bi bi-x-circle me-1"></i> Clear Filters
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-funnel-fill me-1"></i> Apply Filters
            </button>
          </div>
        </div>
      </form>

      <!-- Events List -->
      <div class="row g-4 mt-3">
        @if($events->count() > 0)
          @foreach($events as $event)
          <div class="col-md-6 col-lg-4">
            <div class="card event-card h-100 position-relative shadow-sm">
              <div class="event-status 
                @if($event->status == 1) status-open 
                @else status-full @endif">
                {{ $event->status == 1 ? 'Aktif' : 'Nonaktif' }}
              </div>
              <img
                  src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}"
                  alt="{{ $event->name }}"
                  class="card-img-top rounded-top event-image"
                  style="object-fit:cover; height:180px; cursor:pointer;"
                  data-bs-toggle="modal"
                  data-bs-target="#eventImageModal"
                  data-img="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : asset('images/default-event.jpg') }}"
              >
              <div class="card-body d-flex flex-column">
                <div class="mb-2">
                  @if(!empty($event->category))
                    <span class="badge bg-secondary">{{ ucfirst($event->category) }}</span>
                  @endif
                </div>
                <h5 class="card-title">{{ $event->name }}</h5>
                <p class="card-text text-truncate" title="{{ $event->description }}">{{ $event->description }}</p>
                <div class="event-meta mt-auto">
                  <div class="event-meta-item">
                    <i class="bi bi-calendar-event"></i>
                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                  </div>
                  <div class="event-meta-item">
                    <i class="bi bi-clock"></i>
                    <span>{{ \Carbon\Carbon::parse($event->time)->format('H:i') }} WIB</span>
                  </div>
                  <div class="event-meta-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $event->location }}</span>
                  </div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2">
                  <span class="badge bg-info text-dark">
                    <i class="bi bi-people"></i>
                    {{ $event->registrations_count ?? ($event->registrations->count() ?? 0) }} Peserta
                  </span>
                  @if($event->registration_fee > 0)
                    <span class="badge bg-warning text-dark">
                      <i class="bi bi-cash"></i>
                      Rp{{ number_format($event->registration_fee,0,',','.') }}
                    </span>
                  @else
                    <span class="badge bg-success">
                      Gratis
                    </span>
                  @endif
                </div>
                <small class="text-muted mt-2">
                  Oleh: {{ $event->creator->name ?? '-' }}
                </small>
                @guest
                    <a href="{{ url('/login') }}" class="btn btn-primary mt-3 w-100" aria-label="Login untuk daftar event">
                        <i class="bi bi-box-arrow-in-right"></i> Login untuk Daftar
                    </a>
                @else
                    <a href="{{ route('member.events.show', $event->id) }}" class="btn btn-primary mt-3 w-100" aria-label="Detail {{ $event->name }}">
                        <i class="bi bi-info-circle"></i> Detail & Daftar
                    </a>
                @endguest
              </div>
            </div>
          </div>
          @endforeach
        @else
          <div class="col-12">
            <p class="text-muted text-center fs-5">Tidak ada event yang ditemukan.</p>
          </div>
        @endif
      </div>

      <!-- Pagination -->
      <div class="mt-4 d-flex justify-content-center">
        {{ $events->withQueryString()->links() }}
      </div>
    </div>
  </section>

  <!-- Modal untuk preview gambar event -->
  <div class="modal fade" id="eventImageModal" tabindex="-1" aria-labelledby="eventImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body p-0 text-center">
          <img id="modalEventImage" src="" alt="Event Poster" class="img-fluid rounded shadow" style="max-height:80vh;">
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer text-white text-center py-3 mt-5">
    <div class="container">
      <small>&copy; {{ date('Y') }} UniEvent. All rights reserved.</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('eventImageModal');
    const modalImg = document.getElementById('modalEventImage');
    document.querySelectorAll('.event-image[data-bs-toggle="modal"]').forEach(img => {
        img.addEventListener('click', function() {
            modalImg.src = this.getAttribute('data-img');
        });
    });
    // Bersihkan src saat modal ditutup (opsional)
    modal.addEventListener('hidden.bs.modal', function () {
        modalImg.src = '';
    });
});
</script>
</body>
</html>
