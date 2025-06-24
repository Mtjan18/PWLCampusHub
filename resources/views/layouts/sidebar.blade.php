<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-calendar-event-fill me-2"></i>
            <span>UniEvent</span>
        </a>
        <button class="btn btn-link d-lg-none sidebar-close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            @php
                $role = Auth::check() ? Auth::user()->role->name : null;
            @endphp

            @if($role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.events') }}">
                        <i class="bi bi-calendar-event"></i> <span>All Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.members') }}">
                        <i class="bi bi-people"></i> <span>Members</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.committee.index') }}">
                        <i class="bi bi-person-badge"></i> <span>Committee</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.finance.index') }}">
                        <i class="bi bi-cash-coin"></i> <span>Finance</span>
                    </a>
                </li>
            @elseif($role === 'panitia')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('panitia.dashboard') ? 'active' : '' }}" href="{{ route('panitia.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('panitia.events.create') }}">
                        <i class="bi bi-calendar-plus"></i> <span>Buat Event</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('panitia.attendance.scan') }}">
                        <i class="bi bi-qr-code-scan"></i> <span>Scan Absensi</span>
                    </a>
                </li>
            @elseif($role === 'tim_keuangan')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tim_keuangan.dashboard') ? 'active' : '' }}" href="{{ route('tim_keuangan.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tim_keuangan.payments') }}">
                        <i class="bi bi-cash-coin"></i> <span>Payments</span>
                    </a>
                </li>
            @elseif($role === 'member')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}" href="{{ route('member.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('member.events') }}">
                        <i class="bi bi-calendar-event"></i> <span>My Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('member.payments') }}">
                        <i class="bi bi-credit-card"></i> <span>Payment History</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('member.certificates') }}">
                        <i class="bi bi-award"></i> <span>Certificates</span>
                    </a>
                </li>
            @endif
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
