<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
   
    <!-- Existing styles -->
    @stack('styles')
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f3f6;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #2d3748;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .sidebar .sidebar-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #4a5568;
            color: #fff;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            background-color: #2d3748;
            padding: 15px 20px;
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight: bold;
        }

        .navbar .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #d1d5db;
        }

        .card-header {
            background-color: #4a5568;
            color: #fff;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .btn-outline-primary, .btn-outline-secondary {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .table-striped thead {
            background-color: #4a5568;
            color: white;
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: #f1f3f6;
        }

        .table-striped tbody tr:hover {
            background-color: #edf2f7;
        }

        .display-4 {
            font-size: 2rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            Admin Panel
        </div>
         <a href="{{ route('home') }}"><i class="fas fa-home me-2"></i> Home</a>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profile</a>
         <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Products</a>
        <a href="{{ route('admin.orders.history') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
        
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            <div class="ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="container-fluid mt-3">
            <h1 class="display-4">@yield('title')</h1>
        </div>

        <!-- Page Content -->
        <div class="container-fluid mt-3">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
