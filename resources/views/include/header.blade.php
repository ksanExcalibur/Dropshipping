@php
    use App\Models\Cart;
@endphp

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: rgba(0, 0, 0, 0.7);">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="/images/drop.png" alt="Logo" style="height: 40px;">
      {{ config('app.name') }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Left Links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::routeIs('story') ? 'active' : '' }}" href="{{ route('story') }}">Story</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
        </li>
      </ul>

      <!-- Right Links -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="btn btn-outline-light ms-3" href="{{ route('cart.index') }}">
            <i class="bi bi-cart"></i> Cart
            <span class="badge bg-danger">{{ Cart::where('user_id', Auth::id())->count() }}</span>
          </a>
        </li>

        @auth
          <!-- Profile Dropdown -->
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
              <i class="bi bi-person-circle fs-4"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="dropdown-item-text text-center fw-bold">
                {{ auth()->user()->fullName ?? auth()->user()->name }}
              </li>
              <li><hr class="dropdown-divider"></li>

              <!-- Dashboard Links -->
              @if (auth()->user()->isVendor())
                <li><a class="dropdown-item" href="{{ route('vendor.dashboard') }}">Vendor Dashboard</a></li>
              @elseif(auth()->user()->isAdmin())
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
              @else
                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">User Dashboard</a></li>
              @endif

              <!-- Logout -->
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </li>
        @else
          <!-- Guest Links -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}" style="color: white;">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('registration') }}" style="color: white;">Registration</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Styles -->
<style>
  .navbar {
    padding: 0.5rem 1rem;
  }
  .navbar-brand img {
    height: 40px;
  }
  .navbar-nav .nav-link {
    color: white;
    font-weight: 500;
    margin-right: 15px;
  }
  .navbar-nav .nav-link.active {
    color: #007bff;
  }
  .navbar-nav .nav-link:hover {
    color: #007bff;
  }
  .btn-outline-light {
    border-color: white;
    color: white;
  }
  .btn-outline-light:hover {
    background-color: white;
    color: black;
  }
  .badge.bg-danger {
    background-color: #dc3545;
  }
  .navbar-text {
    font-weight: 500;
    color: white;
  }
</style>

<!-- Bootstrap Icons CDN (if not already included) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
