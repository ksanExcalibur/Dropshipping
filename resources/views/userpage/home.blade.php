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



@endsection