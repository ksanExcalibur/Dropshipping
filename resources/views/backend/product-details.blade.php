@extends('layouts.layout')

@section('title', 'Product Details')

@section('content')
<div class="container product-details-container">
    <div class="product-details-flex">
        <div class="product-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="/images/default.png" alt="Default Image">
            @endif
        </div>
        <div class="product-info">
            <h1 class="product-title">{{ $product->name }}</h1>
            <div class="product-price">Rs. {{ $product->price }}</div>
            <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
            </form>
            <div class="product-description">{{ $product->description }}</div>
        </div>
    </div>

    <div class="comments-section">
        <h2>Comments</h2>
        <div class="comments-card-section">
            <div class="comments-list">
            @foreach($product->comments as $comment)
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="comment-avatar">
                            @if(isset($comment->user->image))
                                <img src="{{ asset('storage/' . $comment->user->image) }}" alt="{{ $comment->user->name }}" />
                            @endif
                        </div>
                        <div class="comment-user-info">
                            <strong>{{ $comment->user->name }}</strong>
                            <small>Posted on {{ $comment->created_at->format('d M, Y') }}</small>
                        </div>
                        <div class="comment-body">
                            <p>{{ $comment->comment }}</p>
                            @if($comment->rating)
                                <div class="comment-rating">
                                @for($i = 1; $i <= 5; $i++)
                                @if($i <= $comment->rating)
                                <span class="fa fa-star checked"></span>
                                @else
                                <span class="fa fa-star"></span>
                                @endif
                                @endfor
                                <span class="rating-value">{{ $comment->rating }} / 5</span>
                                </div>
                            @endif
                            <!-- Delete Button -->
                            <form action="{{ url('/comments/' . $comment->id . '/delete') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                </div>
            @endforeach
            