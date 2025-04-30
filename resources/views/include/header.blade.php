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
      <!-- Search Form -->
      <form action="{{ route('shop') }}" method="GET" class="search-form d-flex me-3">
        <div class="search-wrapper">
          <input type="text" name="search" class="search-input" placeholder="Search products..." value="{{ request('search') }}">
          <button class="search-button" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>

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

<!-- Chat Button -->
<li class="nav-item">
  <a class="btn btn-outline-light ms-3" href="{{ route('chat.index') }}">
    <i class="bi bi-chat-dots"></i> Chat
  </a>
</li>

@auth
    <!-- Notifications Dropdown -->
    <li class="nav-item dropdown ms-3">
        <a class="nav-link dropdown-toggle d-flex align-items-center position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
            <i class="bi bi-bell fs-4"></i>
            @if (auth()->user()->unreadNotifications->count())
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="width: 300px;">
            <li class="dropdown-header">Notifications</li>
            @forelse (auth()->user()->unreadNotifications->take(5) as $notification)
                <li>
                    <a class="dropdown-item small" href="{{ route('notifications.read', $notification->id) }}">
                        {{ $notification->data['message'] ?? 'New notification' }}
                    </a>
                </li>
            @empty
                <li>
                    <span class="dropdown-item text-muted small">No new notifications</span>
                </li>
            @endforelse
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">View All</a>
            </li>
        </ul>
    </li>
@endauth



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
  body {
      padding-top: 100px;
  }
  .navbar {
    padding: 0.5rem 1rem;
    z-index: 1030;
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
  .search-form {
    flex-grow: 1;
    max-width: 500px;
  }
  .search-wrapper {
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
  }
  .search-input {
    width: 100%;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    color: white;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    transition: all 0.3s ease;
  }
  .search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
  }
  .search-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
  }
  .search-button {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    color: white;
    padding: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .search-button:hover {
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

