<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EACC Portal') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            padding-top: 70px; /* Adjusted for fixed navbar height */
        }
        
        .navbar-brand img {
            height: 32px;
            width: auto;
        }
        
        .navbar-dark {
            background-color: #2d2d2d !important;
            border-bottom: 1px solid #404040;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030; /* Ensure navbar is above sidebar */
        }
        
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 70px; /* Start below navbar */
            left: 0;
            background-color: #2d2d2d;
            border-right: 1px solid #404040;
            padding-top: 10px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar.collapsed {
            width: 60px;
        }
        
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        
        .sidebar .nav-link {
            color: #ffffff;
            padding: 10px 15px;
        }
        
        .sidebar .nav-link:hover {
            background-color: #404040;
        }
        
        .sidebar .nav-link.active {
            background-color: #0d6efd;
        }
        
        .sidebar-toggle {
            cursor: pointer;
            padding: 10px;
            background-color: #2d2d2d;
            border-bottom: 1px solid #404040;
        }
        
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            min-height: calc(100vh - 70px); /* Ensure content takes full height minus navbar */
            transition: all 0.3s;
        }
        
        .content-wrapper.collapsed {
            margin-left: 60px;
        }
        
        .card {
            background-color: #2d2d2d;
            border: 1px solid #404040;
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }
        
        .badge-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }
        
        .badge-info {
            background-color: #0dcaf0 !important;
            color: #000 !important;
        }
        
        .badge-success {
            background-color: #198754 !important;
        }
        
        .badge-danger {
            background-color: #dc3545 !important;
        }
        
        .badge-primary {
            background-color: #0d6efd !important;
        }
        
        .form-control, .form-select {
            background-color: #404040;
            border-color: #6c757d;
            color: #ffffff;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: #404040;
            border-color: #0d6efd;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        
        .table-dark {
            --bs-table-bg: #2d2d2d;
        }
        
        .pagination .page-link {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #ffffff;
        }
        
        .pagination .page-link:hover {
            background-color: #404040;
            border-color: #6c757d;
            color: #ffffff;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
            
            .sidebar-toggle-mobile {
                display: block !important;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="btn sidebar-toggle-mobile d-lg-none me-2" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="" alt="EACC Logo" class="me-2">
                EACC Portal
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="bi bi-chevron-left"></i>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door me-2"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('jobs.*') ? 'active' : '' }}" href="{{ route('jobs.index') }}">
                    <i class="bi bi-briefcase me-2"></i>
                    <span class="sidebar-text">Jobs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span class="sidebar-text">Applications</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person me-2"></i>
                    <span class="sidebar-text">Profile</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper" id="content-wrapper">
        <main class="container-fluid">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('content-wrapper');
            sidebar.classList.toggle('collapsed');
            contentWrapper.classList.toggle('collapsed');
            
            // For mobile view
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>