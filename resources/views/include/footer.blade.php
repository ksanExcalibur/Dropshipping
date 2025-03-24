<footer class="footer" style="background-color: black; color: white; padding: 10px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 style="color: white; font-size: 16px;">About</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" style="color: white; font-size: 14px;">Home</a></li>
                    <li><a href="{{ route('shop') }}" style="color: white; font-size: 14px;">Shop</a></li>
                    <li><a href="{{ route('story') }}" style="color: white; font-size: 14px;">Our Story</a></li>
                    <li><a href="{{ route('contact') }}" style="color: white; font-size: 14px;">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 style="color: white; font-size: 16px;">Help</h5>
                <ul class="list-unstyled">
                    <li><a href="#" style="color: white; font-size: 14px;">Shipping & Returns</a></li>
                    <li><a href="#" style="color: white; font-size: 14px;">Track Order</a></li>
                    <li><a href="#" style="color: white; font-size: 14px;">FAQs</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 style="color: white; font-size: 16px;">Contact</h5>
                <ul class="list-unstyled">
                    <li style="color: white; font-size: 14px;">Phone: (+1) 123-456-7893</li>
                    <li style="color: white; font-size: 14px;">Email: name@gmail.com</li>
                </ul>
                <div class="social-icons">
                    <a href="#" style="color: white; font-size: 14px; margin-right: 10px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="color: white; font-size: 14px; margin-right: 10px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: white; font-size: 14px; margin-right: 10px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: white; font-size: 14px;"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col text-center">
                <p style="color: white; font-size: 12px; margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<style>
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