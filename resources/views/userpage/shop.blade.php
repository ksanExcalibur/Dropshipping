@extends('layouts.layout')

@section('title', 'Shop')

@section('content')
<!DOCTYPE html>
<html lang="en">
<body>
    <!-- Hero Section --> 
    <section class="banner">
        <div id="shopCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/top2.jpg" class="d-block w-100" alt="Hero Image 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Welcome to Our Shop</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/images/fashionicon.png" class="d-block w-100" alt="fashion">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Discover Our Collection</h1>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/images/accessories.png" class="d-block w-100" alt="accessories">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Exclusive Offers</h1>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#shopCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#shopCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <div class="container">
        <h2 class="text-center">All Products</h2>
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <img src="/images/default.png" alt="Default Image">
                    @endif
                    @if($product->is_best_seller)
                        <span class="best-seller">Best-seller</span>
                    @elseif($product->is_new)
                        <span class="new">New</span>
                    @endif
                    <h3>{{ $product->name }}</h3>
                    <p class="price">Rs{{ $product->price }} <span class="old-price">${{ $product->old_price }}</span></p>
                    <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn">View Details</a>
                </div>
            @endforeach
        </div>

        <div class="pagination" role="navigation" aria-label="Product pagination">
            <a href="#" aria-label="Previous page">&laquo; Prev</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#" aria-label="Next page">Next &raquo;</a>
        </div>
    </div>
</body>
</html>
@endsection