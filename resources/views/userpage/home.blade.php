@extends('layouts.layout')
@section('title', 'Home')
<style>
    .icon-star-filled { color: yellow; }
</style>
@section('content')

<!-- Hero Section -->
<header class="hero">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/images/hero1.png" class="d-block w-100" alt="Hero Image 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Get Something Nice for Yourself</h1>
                    <p>Discover high-quality products and the latest fashion trends.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/images/fashion.png" class="d-block w-100" alt="Fashion">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find Your Style</h1>
                    <p>Explore our wide range of fashion products.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/images/attire.png" class="d-block w-100" alt="Exclusive">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Exclusive Offers</h1>
                    <p>Get the best deals on top brands.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</header>

<!-- Products Section -->
<section class="products">
    <div class="container">
        <h2><span class="best-white">Best</span> Seller Products</h2>
        <div style="display: flex; align-items: flex-start; position: relative;">
            <div class="product-list" style="flex: 1;">
                @foreach($topRatedProducts as $product)
                <div class="product-card">
                    <div class="product-main-info">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        <h3>{{ $product->name }}</h3>
                        <p>Rs{{ $product->price }} <span class="old-price">{{ $product->old_price }}</span></p>
                        <p>Average Rating: {{ number_format($product->averageRating(), 1) }} / 5</p>
                        <div class="rating-icons">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $product->averageRating())
                                    <span class="icon-star-filled">★</span>
                                @else
                                    <span class="icon-star-empty">☆</span>
                                @endif
                            @endfor
                        </div>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Product</a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="side-images-vertical" style="margin-left: 2rem; display: flex; flex-direction: column; gap: 1.5rem; align-items: center; min-width: 120px;">
                <div class="side-image-block">
                    <img src="/images/controller.png" alt="Side 1" class="side-image" onclick="window.location.href='{{ route('shop', ['category' => 1]) }}'">
                    <span class="side-image-name">Gaming</span>
                </div>
                <div class="side-image-block">
                    <img src="/images/Classic Trench Coat.png" alt="Side 2" class="side-image" onclick="window.location.href='{{ route('shop', ['category' => 2]) }}'">
                    <span class="side-image-name">womenMen</span>
                </div>
                <div class="side-image-block">
                    <img src="/images/DOUBLE BREASTED BLAZER FROM LATE 1900s.png" alt="Side 3" class="side-image" onclick="window.location.href='{{ route('shop', ['category' => 1]) }}'">
                    <span class="side-image-name">Men</span>
                </div>
            </div>
        </div>  
</section>
<!-- Our Story Section -->
<section class="Gaming ">
    <div class="container">
        <div class="row align-items-center">
            <!-- Image -->
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="/images/vr.png" alt="Our Story" class="img-fluid rounded shadow">
            </div>

            <!-- Text Content -->
            <div class="col-md-6">
                <h2 class="mb-4">Gaming</h2>
                <p>Welcome to the ultimate gaming experience, where innovation meets excitement. Dive into a world of immersive gameplay and cutting-edge technology.</p>
                <p>Our gaming collection is designed to elevate your skills and enhance your adventures. From the latest consoles to must-have accessories, we have everything you need to conquer new worlds.</p>
                <p>Join our community of passionate gamers and explore the endless possibilities that await. Whether you're a casual player or a competitive pro, our products are tailored to meet your needs.</p>
                <p>With three Michelin stars and numerous accolades, we continue to push boundaries while honoring the timeless principles of exceptional hospitality.</p>
                 <a href="{{ route('shop', ['category' => 1]) }}" class="btn btn-primary">Gaming Accessories</a>
            </div>
        </div>
    </div>
</section>


<!-- Trends Section -->
<section class="trends">
    <div class="container">
        <h2>Explore Trends</h2>
        <div class="trend-content">
            <div class="trend-card">
                <img src="/images/womentrends.png" alt="Women's Fashion">
                <h3>For Women</h3>
                <p>Welcome to the world of women's fashion, where elegance meets innovation. Discover the latest trends and timeless styles that define modern femininity.</p>
                <p>Our collection is curated to inspire and empower, offering must-have pieces that elevate your wardrobe. From chic dresses to statement accessories, explore the essence of style.</p>
                <p>Join our community of fashion enthusiasts and embrace the beauty of self-expression. Whether you're dressing for a special occasion or everyday elegance, our products cater to your unique taste.</p>
                <a href="{{ route('shop', ['category' => 2]) }}" class="btn btn-secondary">Explore Women</a>
            </div>
            <div class="trend-card">
                <img src="/images/menstrends.png" alt="Men's Fashion">
                <h3>For Men</h3>
                <p>Step into the realm of men's fashion, where sophistication meets versatility. Discover the latest trends and classic styles that define modern masculinity.</p>
                <p>Our collection is designed to inspire confidence and individuality, offering essential pieces that enhance your wardrobe. From tailored suits to casual wear, explore the art of dressing well.</p>
                <p>Join our community of style-savvy individuals and embrace the power of self-expression. Whether you're dressing for business or leisure, our products cater to your unique taste.</p>
                <a href="{{ route('shop', ['category' => 1]) }}" class="btn btn-secondary">Explore Men</a>
            </div>
        </div>
    </div>
</section>



@endsection