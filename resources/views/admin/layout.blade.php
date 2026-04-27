<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Command Center | KSM MotoWorks</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --admin-primary: #0f172a;
            --admin-secondary: #1e293b;
            --accent: #f59e0b;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Layout Structure */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 280px;
            background: var(--admin-primary);
            color: rgba(255, 255, 255, 0.8);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            background: #020617;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 25px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 4px solid transparent;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link-custom:hover {
            color: white;
            background: rgba(255,255,255,0.05);
            border-left-color: var(--accent);
        }

        .nav-link-custom.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: var(--accent);
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            padding: 40px;
            transition: all 0.3s ease;
        }

        /* Top Header */
        .admin-nav {
            background: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }

        .btn-logout {
            color: #ef4444;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 10px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #fef2f2;
        }

        /* Custom UI Components */
        .admin-card {
            background: white;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 991px) {
            .admin-sidebar { margin-left: -280px; }
            .admin-main { margin-left: 0; padding: 20px; }
            .admin-sidebar.active { margin-left: 0; }
        }

        /* Robust SVG Sizing */
        svg { max-width: 20px; max-height: 20px; vertical-align: middle; }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0 text-white fw-bold tracking-tight">KSM MotoWorks <span class="text-warning text-xs">ADMIN</span></h5>
            </div>
            
            <div class="py-4">
                <div class="px-4 mb-2">
                    <small class="text-uppercase fw-bold text-muted opacity-50" style="font-size: 0.7rem;">Main Controls</small>
                </div>
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ Request::is('admin') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Dashboard Hub
                    </a>
                    <a href="{{ route('admin.appointments') }}" class="nav-link-custom {{ Request::is('admin/appointments*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Manage Bookings
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-link-custom {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i> User Management
                    </a>
                    <a href="{{ route('admin.queries') }}" class="nav-link-custom {{ Request::is('admin/queries*') ? 'active' : '' }}">
                        <i class="fas fa-envelope-open-text"></i> Client Queries
                    </a>
                    
                    <div class="px-4 mt-4 mb-2">
                        <small class="text-uppercase fw-bold text-muted opacity-50" style="font-size: 0.7rem;">External</small>
                    </div>
                    <a href="{{ route('home') }}" class="nav-link-custom">
                        <i class="fas fa-external-link-alt"></i> View Public Site
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-nav animate__animated animate__fadeInDown">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">@yield('title')</h4>
                    <p class="text-muted small mb-0">Command Center / {{ \Carbon\Carbon::now()->format('l, d M Y') }}</p>
                </div>
                
                <div class="d-flex align-items-center gap-4">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold small">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">System Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4 animate__animated animate__fadeIn">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Content Area -->
            <div class="animate__animated animate__fadeIn">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
