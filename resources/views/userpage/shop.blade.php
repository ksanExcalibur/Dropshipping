@extends('layouts.layout')

@section('title', 'Shop')

@section('content')
<!DOCTYPE html>
<html lang="en">
<body>
  
    <div class="container">
        <h2 class="text-center">All Products</h2>
        <div class="row mb-4">
            <div class="col-md-3">
                <form method="GET" action="">
                    <div class="form-group">
                        <label for="category">Filter by Category:</label>
                        <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="product-grid">
            @if($products->isEmpty())
                <div class="alert alert-info text-center">
                    No products found matching your search criteria.
                </div>
            @else
                @foreach($products as $product)
                    <div class="product">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; height: 200px; object-fit: contain;">
                        @else
                            <img src="/images/default.png" alt="Default Image" style="max-width: 100%; height: 200px; object-fit: contain;">
                        @endif
                    @if($product->is_best_seller)
                        <span class="best-seller">Best-seller</span>
                    @elseif($product->is_new)
                        <span class="new">New</span>
                    @endif
                    <h3>{{ $product->name }}</h3>
                    <p class="price">Rs{{ $product->price }} <span class="old-price">${{ $product->old_price }}</span></p>
                    <p class="category">Category: {{ $product->category ? $product->category->name : 'Uncategorized' }}</p>
                    <a href="{{ route('product.show', ['id' => $product->id]) }}" class="btn">View Details</a>
                    </div>
                @endforeach
            @endif
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