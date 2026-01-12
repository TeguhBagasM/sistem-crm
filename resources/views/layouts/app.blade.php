<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .badge-primary { background-color: #3498db; }
        .badge-info { background-color: #17a2b8; }
        .badge-warning { background-color: #f39c12; }
        .badge-success { background-color: #27ae60; }
        .badge-danger { background-color: #e74c3c; }
        .badge-secondary { background-color: #95a5a6; }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="p-4 text-white">
                    <h4 class="mb-0"><i class="bi bi-building"></i> CRM System</h4>
                    <small>{{ auth()->user()->name }}</small>
                    <span class="badge bg-light text-dark ms-2">
                        {{ strtoupper(auth()->user()->role) }}
                    </span>
                </div>

                <nav class="nav flex-column px-3">
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

                    <hr class="bg-light">

                    <a class="nav-link text-danger" href="{{ route('logout') }}"
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

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
