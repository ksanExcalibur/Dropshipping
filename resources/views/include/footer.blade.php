<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="footer-title">About</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ route('shop') }}" class="footer-link">Shop</a></li>
                    
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-unstyled">
                    <li><a href="{{ route('story') }}" class="footer-link">Our Story</a></li>
                    <li><a href="{{ route('user.orders') }}" class="footer-link">Shipping</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="list-unstyled">
                    <li class="footer-text">Phone: (+1) 123-456-7893</li>
                    <li class="footer-text">Email: name@gmail.com</li>
                </ul>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col text-center">
                <p class="footer-copy">&copy; {{ date('Y') }} {{ config('Dropshipping') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<<style>
  .footer {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }
  .footer a {
    color: white;
    text-decoration: none;
  }
  .footer a:hover {
    color: #007bff;
  }
  .social-icons a {
    margin-right: 10px;
    font-size: 1.2rem;
  }
  .social-icons a:hover {
    color: #007bff;
  }
</style>