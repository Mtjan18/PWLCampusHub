    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="../index.html" class="sidebar-brand">
                <i class="bi bi-calendar-event-fill me-2"></i>
                <span>UniEvent</span>
            </a>
            <button class="btn btn-link d-lg-none sidebar-close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>


        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="member-dashboard.html">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member-events.html">
                        <i class="bi bi-calendar-event"></i>
                        <span>My Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member-payments.html">
                        <i class="bi bi-credit-card"></i>
                        <span>Payment History</span>
                    </a>
                </li>
            </ul>
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a href="#" class="btn btn-outline-light btn-sm"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i>
            <span>Logout</span>
        </a>

    </aside>
