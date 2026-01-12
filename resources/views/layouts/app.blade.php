<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 50%, #1e3c72 100%);
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-header h4 {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .sidebar-header .user-info {
            display: flex;
            align-items: center;
            margin-top: 1rem;
            padding: 0.75rem;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .sidebar-header .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
            margin-right: 0.75rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .sidebar-header .user-details {
            flex: 1;
        }

        .sidebar-header .user-name {
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .sidebar-header .user-role {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(245, 87, 108, 0.3);
        }

        .sidebar-nav {
            padding: 1.5rem 1rem;
            position: relative;
            z-index: 1;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 0.9rem 1.2rem;
            margin: 0.4rem 0;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 0.75rem;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar .nav-link:hover::before {
            transform: scaleY(1);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.15) 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .sidebar .nav-link.active::before {
            transform: scaleY(1);
        }

        .sidebar .nav-link.active i {
            transform: scale(1.15);
        }

        .sidebar hr {
            border-color: rgba(255,255,255,0.2);
            margin: 1.5rem 0;
        }

        .sidebar .nav-link.text-danger:hover {
            background: rgba(231, 76, 60, 0.2);
            color: #ff6b6b !important;
        }

        .card {
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }

        .badge-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .badge-info { background: linear-gradient(135deg, #17a2b8 0%, #1c8fa8 100%); }
        .badge-warning { background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); }
        .badge-success { background: linear-gradient(135deg, #27ae60 0%, #229954 100%); }
        .badge-danger { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); }
        .badge-secondary { background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%); }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>

    @stack('styles')
</head>
<body>
    @auth
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="sidebar-header">
                    <h4><i class="bi bi-building"></i> CRM System</h4>

                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <span class="user-role">{{ auth()->user()->role }}</span>
                        </div>
                    </div>
                </div>

                <nav class="nav flex-column sidebar-nav">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>

                    @if(auth()->user()->hasAccess(['marketing1']))
                    <a class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}" href="{{ route('leads.index') }}">
                        <i class="bi bi-person-plus"></i> Lead Management
                    </a>
                    @endif

                    @if(auth()->user()->hasAccess(['marketing2']))
                    <a class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
                        <i class="bi bi-people"></i> Contact Management
                    </a>
                    @endif

                    @if(auth()->user()->hasAccess(['marketing3']))
                    <a class="nav-link {{ request()->routeIs('emails.*') ? 'active' : '' }}" href="{{ route('emails.index') }}">
                        <i class="bi bi-envelope"></i> Email Management
                    </a>
                    @endif

                    @if(auth()->user()->hasAccess(['marketing4']))
                    <a class="nav-link {{ request()->routeIs('aktivitas.*') ? 'active' : '' }}" href="{{ route('aktivitas.index') }}">
                        <i class="bi bi-calendar"></i> Calendar & Activities
                    </a>
                    @endif

                    <hr>

                    <a class="nav-link text-light" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            @endauth

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
