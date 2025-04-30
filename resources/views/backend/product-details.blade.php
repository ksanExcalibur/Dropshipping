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
            </div>
            @if(Auth::check())
                <div class="comment-form-card">
                    <h3>Leave a Comment</h3>
                    <form action="{{ url('/products/' . $product->id . '/comment') }}" method="POST" class="modern-comment-form">
                        @csrf
                        <div class="form-group">
                            <textarea name="comment" class="form-control stylish-textarea" required placeholder="Write your comment..."></textarea>
                        </div>
                        <div class="form-group">
                            <div class="star-rating-input">
                                <input type="hidden" name="rating" id="rating-value" value="">
                                <span class="star-input" data-value="1">&#9734;</span>
                                <span class="star-input" data-value="2">&#9734;</span>
                                <span class="star-input" data-value="3">&#9734;</span>
                                <span class="star-input" data-value="4">&#9734;</span>
                                <span class="star-input" data-value="5">&#9734;</span>
                                <span class="rating-label">Your Rating</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const stars = document.querySelectorAll('.star-input');
                    const ratingValue = document.getElementById('rating-value');
                    let currentRating = 0;
                    stars.forEach(star => {
                        star.addEventListener('mouseenter', function() {
                            const val = parseInt(this.getAttribute('data-value'));
                            highlightStars(val);
                        });
                        star.addEventListener('mouseleave', function() {
                            highlightStars(currentRating);
                        });
                        star.addEventListener('click', function() {
                            currentRating = parseInt(this.getAttribute('data-value'));
                            ratingValue.value = currentRating;
                            highlightStars(currentRating);
                        });
                    });
                    function highlightStars(rating) {
                        stars.forEach(star => {
                            const val = parseInt(star.getAttribute('data-value'));
                            if(val <= rating) {
                                star.innerHTML = '\u2605';
                                star.classList.add('filled');
                            } else {
                                star.innerHTML = '\u2606';
                                star.classList.remove('filled');
                            }
                        });
                    }
                });
                </script>
            @else
                <div class="comment-form-card">
                    <p>Please <a href="{{ route('login') }}">login</a> to comment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/product-details.css') }}">
<style>
.product-details-flex {
    display: flex;
    gap: 40px;
    align-items: flex-start;
    margin-bottom: 40px;
}
.product-image {
    flex: 1 1 350px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.product-info {
    flex: 1 1 350px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
}
.product-description {
    margin-top: 20px;
    color: #444;
    font-size: 1.1em;
    line-height: 1.6;
}
@media (max-width: 900px) {
    .product-details-flex {
        flex-direction: column;
        gap: 20px;
    }
    .product-info, .product-image {
        align-items: center;
        width: 100%;
    }
}
</style>
@endsection