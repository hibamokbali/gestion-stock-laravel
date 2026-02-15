<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gestion Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1a1f3a 0%, #0f1419 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .sidebar-brand i {
            font-size: 1.75rem;
            margin-right: 0.75rem;
            color: #4e73df;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            margin: 0.25rem 0.75rem;
            color: #a8b4c4;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
        }

        .sidebar-item i {
            font-size: 1.25rem;
            margin-right: 0.875rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            height: var(--header-height);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3e6ea;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .stat-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card-title {
            color: #6c757d;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-card-value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        /* Table */
        .table-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3e6ea;
        }

        .table thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Buttons */
        .btn {
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-success {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #f85032 0%, #e73827 100%);
            border: none;
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        /* Badges */
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            font-size: 0.75rem;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            border: 2px solid #e3e6ea;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        /* Alerts */
        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="bi bi-box-seam-fill"></i>
                <span>Gestion Stock</span>
            </a>
        </div>

        <div class="sidebar-menu">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="sidebar-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="{{ route('admin.directions.index') }}" class="sidebar-item {{ request()->routeIs('admin.directions.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Directions</span>
            </a>

            <a href="{{ route('admin.magasins.index') }}" class="sidebar-item {{ request()->routeIs('admin.magasins.*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i>
                <span>Magasins</span>
            </a>

            <a href="{{ route('admin.employes.index') }}" class="sidebar-item {{ request()->routeIs('admin.employes.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i>
                <span>Employés</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span>Catégories</span>
            </a>

            <a href="{{ route('admin.unites.index') }}" class="sidebar-item {{ request()->routeIs('admin.unites.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Articles</span>
            </a>

            <a href="{{ route('admin.fournisseurs.index') }}" class="sidebar-item {{ request()->routeIs('admin.fournisseurs.*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i>
                <span>Fournisseurs</span>
            </a>
            @endif

            <!-- Accessible par Admin ET User -->
            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index') }}" class="sidebar-item {{ request()->routeIs('*.entrees.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i>
                <span>Entrées</span>
            </a>

            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index') }}" class="sidebar-item {{ request()->routeIs('*.sorties.*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up"></i>
                <span>Sorties</span>
            </a>

            <a href="{{ route(auth()->user()->isAdmin() ? 'admin.stock.index' : 'user.stock.index') }}" class="sidebar-item {{ request()->routeIs('*.stock.*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-data"></i>
                <span>État du Stock</span>
            </a>
        </div>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title', 'Gestion de Stock')</title>

            <!-- Bootstrap 5 -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

            <!-- Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

            <!-- Google Fonts -->
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: 'Inter', sans-serif;
                    background: #f8f9fa;
                    overflow-x: hidden;
                }

                .sidebar {
                    position: fixed;
                    top: 0;
                    left: 0;
                    height: 100vh;
                    width: 260px;
                    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
                    color: white;
                    padding: 20px 0;
                    z-index: 1000;
                    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
                    overflow-y: auto;
                }

                .sidebar::-webkit-scrollbar {
                    width: 6px;
                }

                .sidebar::-webkit-scrollbar-track {
                    background: rgba(255, 255, 255, 0.05);
                }

                .sidebar::-webkit-scrollbar-thumb {
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 3px;
                }

                .sidebar-header {
                    padding: 0 20px 20px;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                    margin-bottom: 20px;
                }

                .sidebar-header h4 {
                    font-size: 20px;
                    font-weight: 700;
                    margin-bottom: 5px;
                    color: #fff;
                }

                .sidebar-header .user-info {
                    font-size: 13px;
                    color: rgba(255, 255, 255, 0.7);
                }

                .sidebar-menu {
                    padding: 0;
                }

                .sidebar-item {
                    display: flex;
                    align-items: center;
                    padding: 12px 20px;
                    color: rgba(255, 255, 255, 0.8);
                    text-decoration: none;
                    transition: all 0.3s ease;
                    font-size: 14px;
                    font-weight: 500;
                    border-left: 3px solid transparent;
                }

                .sidebar-item:hover {
                    background: rgba(255, 255, 255, 0.08);
                    color: white;
                    border-left-color: #3b82f6;
                }

                .sidebar-item.active {
                    background: rgba(59, 130, 246, 0.2);
                    color: white;
                    border-left-color: #3b82f6;
                }

                .sidebar-item i {
                    font-size: 20px;
                    margin-right: 12px;
                    width: 24px;
                    text-align: center;
                }

                .sidebar-divider {
                    padding: 15px 0 10px;
                    font-size: 11px;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                    opacity: 0.6;
                    margin: 10px 20px 5px;
                }


                .main-content {
                    margin-left: 260px;
                    min-height: 100vh;
                    padding: 30px;
                }

                .topbar {
                    background: white;
                    padding: 20px 30px;
                    border-radius: 12px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    margin-bottom: 30px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .page-title {
                    font-size: 28px;
                    font-weight: 700;
                    color: #1e293b;
                    margin: 0;
                }


                .table-card {
                    background: white;
                    border-radius: 12px;
                    padding: 25px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                }

                .stat-card {
                    background: white;
                    border-radius: 12px;
                    padding: 20px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    transition: transform 0.3s ease;
                }

                .stat-card:hover {
                    transform: translateY(-5px);
                }

                .stat-card-icon {
                    width: 60px;
                    height: 60px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 28px;
                    margin-bottom: 15px;
                }

                .stat-card-title {
                    font-size: 13px;
                    color: #64748b;
                    font-weight: 600;
                    text-transform: uppercase;
                    margin-bottom: 8px;
                }

                .stat-card-value {
                    font-size: 32px;
                    font-weight: 700;
                    margin-bottom: 5px;
                }

                .alert {
                    border: none;
                    border-radius: 10px;
                    padding: 15px 20px;
                }

                .btn {
                    border-radius: 8px;
                    padding: 10px 20px;
                    font-weight: 600;
                    transition: all 0.3s ease;
                }


                .table {
                    margin-bottom: 0;
                }

                .table thead th {
                    border-bottom: 2px solid #e2e8f0;
                    color: #475569;
                    font-weight: 700;
                    font-size: 13px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    padding: 15px;
                }

                .table tbody td {
                    padding: 15px;
                    vertical-align: middle;
                    border-bottom: 1px solid #f1f5f9;
                }

                .table-hover tbody tr:hover {
                    background-color: #f8fafc;
                }


                .form-label {
                    font-weight: 600;
                    color: #334155;
                    margin-bottom: 8px;
                }

                .form-control,
                .form-select {
                    border: 1px solid #e2e8f0;
                    border-radius: 8px;
                    padding: 10px 15px;
                    transition: all 0.3s ease;
                }

                .form-control:focus,
                .form-select:focus {
                    border-color: #3b82f6;
                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                }

                .badge {
                    padding: 6px 12px;
                    font-weight: 600;
                    border-radius: 6px;
                }


                @media (max-width: 768px) {
                    .sidebar {
                        width: 0;
                        overflow: hidden;
                    }

                    .main-content {
                        margin-left: 0;
                        padding: 15px;
                    }

                    .page-title {
                        font-size: 22px;
                    }
                }
            </style>
        </head>

        <body>

            <div class="sidebar">
                <div class="sidebar-header">
                    <h4><i class="bi bi-box-seam me-2"></i>Stock Manager</h4>
                    <div class="user-info">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ auth()->user()->name }}
                        <small class="d-block mt-1">
                            {{ auth()->user()->isAdmin() ? 'Administrateur' : 'Utilisateur' }}
                        </small>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <!-- Dashboard -->
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="sidebar-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                    <!-- Séparateur -->
                    <div class="sidebar-divider">GESTION</div>

                    <a href="{{ route('admin.users.index') }}" class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Utilisateurs</span>
                    </a>

                    <a href="{{ route('admin.directions.index') }}" class="sidebar-item {{ request()->routeIs('admin.directions.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Directions</span>
                    </a>

                    <a href="{{ route('admin.magasins.index') }}" class="sidebar-item {{ request()->routeIs('admin.magasins.*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>
                        <span>Magasins</span>
                    </a>

                    <a href="{{ route('admin.employes.index') }}" class="sidebar-item {{ request()->routeIs('admin.employes.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Employés</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags-fill"></i>
                        <span>Catégories</span>
                    </a>

                    <a href="{{ route('admin.unites.index') }}" class="sidebar-item {{ request()->routeIs('admin.unites.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Articles</span>
                    </a>

                    <a href="{{ route('admin.fournisseurs.index') }}" class="sidebar-item {{ request()->routeIs('admin.fournisseurs.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i>
                        <span>Fournisseurs</span>
                    </a>
                    @endif

                    <!-- Séparateur -->
                    <div class="sidebar-divider">STOCK</div>

                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.entrees.index' : 'user.entrees.index') }}" class="sidebar-item {{ request()->routeIs('*.entrees.*') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-down"></i>
                        <span>Entrées</span>
                    </a>

                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.sorties.index' : 'user.sorties.index') }}" class="sidebar-item {{ request()->routeIs('*.sorties.*') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-up"></i>
                        <span>Sorties</span>
                    </a>

                    <a href="{{ route(auth()->user()->isAdmin() ? 'admin.stock.index' : 'user.stock.index') }}" class="sidebar-item {{ request()->routeIs('*.stock.*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-data"></i>
                        <span>État du Stock</span>
                    </a>

                    <!-- Séparateur -->
                    <div class="sidebar-divider">COMPTE</div>

                    <a href="{{ route('logout') }}" class="sidebar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Déconnexion</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>


            <div class="main-content">
                <!-- Topbar -->
                <div class="topbar">
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    <div>
                        <span class="badge bg-primary">{{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Erreurs :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif


                @yield('content')
            </div>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            @yield('scripts')
        </body>

        </html>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>


    <div class="main-wrapper">

        <nav class="top-navbar d-flex align-items-center px-4">
            <h4 class="mb-0 fw-bold text-dark">@yield('title', 'Dashboard')</h4>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-muted">{{ auth()->user()->name }}</span>
            </div>
        </nav>

        <div class="content-area">

            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mb-4">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>
                        <strong>Erreurs de validation :</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>