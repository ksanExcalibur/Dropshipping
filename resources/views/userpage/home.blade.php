@extends('layouts.layout')
@section('title', 'Home')
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
                <img src="/images/fashion.png" class="d-block w-100" alt="fashion">
                <div class="carousel-caption d-none d-md-block">
                    <h1>Find Your Style</h1>
                    <p>Explore our wide range of fashion products.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/images/top2.jpg" class="d-block w-100" alt="hero">
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
    <div>
        <h2>Top Rated Products</h2>
        <div class="product-list">
            @foreach($topRatedProducts as $product)
            <div class="product">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                <h3>{{ $product->name }}</h3>
                <p>${{ $product->price }} <span class="old-price">{{ $product->old_price }}</span></p>
                <p>Average Rating: {{ number_format($product->averageRating(), 1) }} / 5</p>
                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Product</a>
            </div>
            @endforeach
        </div>
    <div class="container">
        <h2>Our Products</h2>
        <div class="product-buttons">
            <button class="btn active">Best-selling</button>
            <button class="btn">All Products</button>
        </div>
        <div class="product-list">
            @foreach($products as $product)
            <div class="product-card">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                <h3>{{ $product->name }}</h3>
                <p>${{ $product->price }} <span class="old-price">Rs{{ $product->old_price }}</span></p>
                <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn btn-primary">View Details</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Trends Section -->
<section class="trends">
    <div class="container">
        <h2>Men's Trends</h2>
        <div class="trend-content">
            <div class="trend-card">
                <h3>For Women</h3>
                <img src="/images/Womentrends.png" alt="Women's Fashion">
                <a href="{{ route('shop') }}?category=women" class="btn btn-secondary">Explore</a>
            </div>
            <div class="trend-card">
                <h3>For Men</h3>
                <img src="/images/menstrends.png" alt="Men's Fashion">
                <a href="{{ route('shop') }}?category=men" class="btn btn-secondary">Explore</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h2>Women's Trends</h2>
        <div class="trend-gallery">
            <div class="gallery-item">
                <img src="/images/richgirl.png" alt="Women's Collection">
                <a href="{{ route('shop') }}?category=women" class="btn btn-secondary">View Collection</a>
            </div>
        </div>
    </div>
</section>

<!-- Bestselling Section -->
<section class="bestselling">
    <div class="container">
        <h2>Bestselling</h2>
        <div class="product-grid">
            <img src="/images/product4.jpg" alt="Product 5">
            <img src="/images/mwc.png" alt="Product 6">
            <img src="/images/lotion.png" alt="Product 7">
            <img src="/images/touch.png" alt="Product 8">
            <img src="/images/leather.png" alt="Product 9">
            <img src="/images/another.png" alt="Product 10">
            <img src="/images/jacket.png" alt="Product 11">
            <img src="/images/kisy.png" alt="Product 12">
            <img src="/images/spray.png" alt="Product 13">
            <img src="/images/candle.png" alt="Product 14">
            <img src="/images/globle.png" alt="Product 15">
            <img src="/images/candle.png" alt="Product 16">
        </div>
    </div>
</section>

@endsection