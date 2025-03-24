<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Dashboard')</title>
  
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
      body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
      }
      .sidebar {
        height: 100vh;
        background-color: #1e1e2f;
        color: #fff;
        position: fixed;
        width: 220px;
        padding-top: 20px;
      }
      .sidebar a {
        color: #cfd8dc;
        text-decoration: none;
        display: block;
        padding: 15px 20px;
        transition: 0.3s;
      }
      .sidebar a:hover {
        background-color: #343a40;
        color: #fff;
      }
      .sidebar .sidebar-heading {
        text-align: center;
        margin-bottom: 30px;
        font-size: 1.4rem;
        color: #f8f9fa;
      }
      .main-content {
        margin-left: 220px;
        padding: 30px;
      }
      .logout-btn {
        position: absolute;
        bottom: 20px;
        width: 100%;
      }
    </style>
  </head>
  <body>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-heading">User Panel</div>
      <a href="{{ route('user.dashboard') }}"><i class="fas fa-user me-2"></i> Profile</a>
      <a href="{{ route('user.orders') }}"><i class="fas fa-shopping-bag me-2"></i> My Orders</a>
      <a href="{{ route('payment.success') }}"><i class="fas fa-money-bill me-2"></i> Payment</a>
      <a href="{{ route('logout') }}" class="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      @yield('content')
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
