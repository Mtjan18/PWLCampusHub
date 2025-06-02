<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UniEvent')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&family=Open+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/'; // Redirect ke login
            }
        });
    </script>

</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <main class="dashboard-main">
            {{-- Top Navbar --}}
            @include('layouts.navbar')

            {{-- Page Content --}}
            {{-- <div class="container-fluid px-4 py-4"> --}}
            @yield('content')
    </div>
    </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();

            // Hapus token & user info dari localStorage
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            // Redirect ke halaman login (ubah sesuai kebutuhan)
            window.location.href = '/'; // atau ke halaman utama
        });
    </script>

</body>

</html>
