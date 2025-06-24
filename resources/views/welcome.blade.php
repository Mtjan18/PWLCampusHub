<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CampusHub - University Event Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.html">
        <i class="bi bi-calendar-event-fill me-2"></i>
        <span>CampusHub</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('events') }}">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html">About</a>
          </li>
        </ul>
        <div class="d-flex">
          <a href="{{ url('/login') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section text-white text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">University Event Management</h1>
          <p class="lead mb-5 animate__animated animate__fadeInUp">Register for events, track attendance, and get certificates - all in one place</p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center animate__animated animate__fadeInUp animate__delay-1s">
            <a href="{{ route('events') }}" class="btn btn-primary btn-lg px-4 gap-3">Explore Events</a>
            <a href="{{ url('/register') }}" class="btn btn-outline-light btn-lg px-4">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Events -->
  <section class="featured-events py-5">
    <div class="container">
      <div class="section-header text-center mb-5">
        <h2 class="fw-bold">Featured Events</h2>
        <p class="text-muted">Discover upcoming events at the university</p>
      </div>
      
      <div class="row g-4">
        @php
          // Get upcoming events that are active
          $featuredEvents = \App\Models\Event::where('status', 1)
                         ->where('date', '>=', \Carbon\Carbon::today())
                         ->orderBy('date')
                         ->take(3)
                         ->get();
        @endphp

        @forelse($featuredEvents as $event)
          <div class="col-md-6 col-lg-4">
            <div class="card event-card h-100">
              <div class="event-image">
                <img src="{{ $event->poster_url ? asset('storage/' . $event->poster_url) : 'https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg' }}" 
                     class="card-img-top" alt="{{ $event->name }}" style="height: 200px; object-fit: cover;">
                <span class="event-category">
                  @if($event->sessions->count() > 0)
                    {{ $event->sessions->count() }} Session(s)
                  @else
                    Event
                  @endif
                </span>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="event-date"><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                  <span class="event-time"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                </div>
                <h5 class="card-title">{{ $event->name }}</h5>
                <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description ?? 'Join this exciting event at the university.', 80) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <span class="event-price">
                    @if($event->registration_fee > 0)
                      Rp{{ number_format($event->registration_fee,0,',','.') }}
                    @else
                      Free
                    @endif
                  </span>
                  <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary">View Details</a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <!-- Display placeholder cards if no events are available -->
          <div class="col-md-6 col-lg-4">
            <div class="card event-card h-100">
              <div class="event-image">
                <img src="https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg" class="card-img-top" alt="Tech Conference">
                <span class="event-category">Technology</span>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="event-date"><i class="bi bi-calendar3"></i> Jun 15, 2025</span>
                  <span class="event-time"><i class="bi bi-clock"></i> 10:00 AM</span>
                </div>
                <h5 class="card-title">AI in Education Conference</h5>
                <p class="card-text">Explore the latest applications of artificial intelligence in modern education.</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <span class="event-price">$25.00</span>
                  <a href="{{ route('events') }}" class="btn btn-outline-primary">View Details</a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-4">
            <div class="card event-card h-100">
              <div class="event-image">
                <img src="https://images.pexels.com/photos/2608517/pexels-photo-2608517.jpeg" class="card-img-top" alt="Leadership Workshop">
                <span class="event-category">Workshop</span>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="event-date"><i class="bi bi-calendar3"></i> Jul 10, 2025</span>
                  <span class="event-time"><i class="bi bi-clock"></i> 2:00 PM</span>
                </div>
                <h5 class="card-title">Leadership Development Workshop</h5>
                <p class="card-text">Develop essential leadership skills with industry experts and interactive sessions.</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <span class="event-price">$15.00</span>
                  <a href="{{ route('events') }}" class="btn btn-outline-primary">View Details</a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-4">
            <div class="card event-card h-100">
              <div class="event-image">
                <img src="https://images.pexels.com/photos/1708936/pexels-photo-1708936.jpeg" class="card-img-top" alt="Design Thinking">
                <span class="event-category">Seminar</span>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="event-date"><i class="bi bi-calendar3"></i> Aug 5, 2025</span>
                  <span class="event-time"><i class="bi bi-clock"></i> 9:30 AM</span>
                </div>
                <h5 class="card-title">Design Thinking in Research</h5>
                <p class="card-text">Learn how to apply design thinking methodology to enhance your research projects.</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <span class="event-price">Free</span>
                  <a href="{{ route('events') }}" class="btn btn-outline-primary">View Details</a>
                </div>
              </div>
            </div>
          </div>
        @endforelse
      </div>
      
      <div class="text-center mt-5">
        <a href="{{ route('events') }}" class="btn btn-primary">View All Events</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features-section py-5 bg-light">
    <div class="container">
      <div class="section-header text-center mb-5">
        <h2 class="fw-bold">Why Choose UniEvent</h2>
        <p class="text-muted">Our platform makes event management simple and efficient</p>
      </div>
      
      <div class="row g-4">
        <!-- Feature 1 -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="feature-icon mb-3">
              <i class="bi bi-calendar-check"></i>
            </div>
            <h5 class="feature-title">Easy Registration</h5>
            <p class="feature-text">Register for events quickly with just a few clicks. Secure payment options available.</p>
          </div>
        </div>
        
        <!-- Feature 2 -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="feature-icon mb-3">
              <i class="bi bi-qr-code-scan"></i>
            </div>
            <h5 class="feature-title">QR Code Check-in</h5>
            <p class="feature-text">Effortless event check-in with secure QR codes. No more paper tickets or long queues.</p>
          </div>
        </div>
        
        <!-- Feature 3 -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="feature-icon mb-3">
              <i class="bi bi-award"></i>
            </div>
            <h5 class="feature-title">Digital Certificates</h5>
            <p class="feature-text">Receive verified digital certificates directly to your account after attending events.</p>
          </div>
        </div>
        
        <!-- Feature 4 -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="feature-icon mb-3">
              <i class="bi bi-bell"></i>
            </div>
            <h5 class="feature-title">Event Notifications</h5>
            <p class="feature-text">Get timely reminders and updates about your registered events.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials-section py-5">
    <div class="container">
      <div class="section-header text-center mb-5">
        <h2 class="fw-bold">What Our Users Say</h2>
        <p class="text-muted">Hear from students and event organizers</p>
      </div>
      
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Testimonial 1 -->
              <div class="carousel-item active">
                <div class="testimonial-card text-center">
                  <div class="testimonial-image">
                    <img src="https://images.pexels.com/photos/3771089/pexels-photo-3771089.jpeg" alt="Student">
                  </div>
                  <p class="testimonial-text">"UniEvent has made it so easy to keep track of all the workshops and seminars I attend. The digital certificates are a huge plus!"</p>
                  <h5 class="testimonial-name">Sarah Johnson</h5>
                  <p class="testimonial-role">Computer Science Student</p>
                </div>
              </div>
              
              <!-- Testimonial 2 -->
              <div class="carousel-item">
                <div class="testimonial-card text-center">
                  <div class="testimonial-image">
                    <img src="https://images.pexels.com/photos/1181391/pexels-photo-1181391.jpeg" alt="Professor">
                  </div>
                  <p class="testimonial-text">"As an event organizer, I've found the platform incredibly helpful. The QR code check-in system has saved us countless hours of manual work."</p>
                  <h5 class="testimonial-name">Dr. Michael Chen</h5>
                  <p class="testimonial-role">Associate Professor</p>
                </div>
              </div>
              
              <!-- Testimonial 3 -->
              <div class="carousel-item">
                <div class="testimonial-card text-center">
                  <div class="testimonial-image">
                    <img src="https://images.pexels.com/photos/762020/pexels-photo-762020.jpeg" alt="Admin">
                  </div>
                  <p class="testimonial-text">"Managing university events has never been easier. The comprehensive dashboard gives me all the information I need at a glance."</p>
                  <h5 class="testimonial-name">Lisa Rodriguez</h5>
                  <p class="testimonial-role">Event Administrator</p>
                </div>
              </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="cta-section text-white text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2 class="fw-bold mb-4">Ready to get started?</h2>
          <p class="lead mb-5">Join thousands of students and staff members already using UniEvent</p>
          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="{{ url('/register') }}" class="btn btn-primary btn-lg px-4 gap-3">Create Account</a>
            <a href="events.html" class="btn btn-outline-light btn-lg px-4">Browse Events</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <h5 class="text-white mb-4">UniEvent</h5>
          <p class="text-muted mb-4">Your comprehensive solution for university event management, registration, and attendance tracking.</p>
          <div class="social-links">
            <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
            <a href="#" class="me-2"><i class="bi bi-twitter"></i></a>
            <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
            <a href="#" class="me-2"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
          <h5 class="text-white mb-4">Quick Links</h5>
          <ul class="list-unstyled footer-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="events.html">Events</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        
        <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
          <h5 class="text-white mb-4">Resources</h5>
          <ul class="list-unstyled footer-links">
            <li><a href="#">Help Center</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        
        <div class="col-lg-4 col-md-4">
          <h5 class="text-white mb-4">Stay Updated</h5>
          <p class="text-muted mb-4">Subscribe to our newsletter for the latest events and updates.</p>
          <form class="mb-3">
            <div class="input-group">
              <input type="email" class="form-control" placeholder="Your email address" aria-label="Your email address">
              <button class="btn btn-primary" type="button">Subscribe</button>
            </div>
          </form>
        </div>
      </div>
      
      <hr class="mt-4 mb-3">
      
      <div class="row">
        <div class="col-md-6 text-center text-md-start">
          <p class="text-muted mb-0">&copy; 2025 UniEvent. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <p class="text-muted mb-0">Designed with <i class="bi bi-heart-fill text-danger"></i> for university events</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>

