@extends('layouts.layout')

@section('title', 'Product Details')

@section('content')
<div class="container">
    <div class="product-details">
        <h1>{{ $product->name }}</h1>
        <div class="product-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="/images/default.png" alt="Default Image">
            @endif
        </div>
        <div class="product-info">
            <p>{{ $product->description }}</p>
            <p class="price">Rs. {{ $product->price }}</p>
            <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </div>

    <div class="comments-section">
        <h2>Comments</h2>
        @foreach($product->comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->comment }}</p>
                @if($comment->rating)
                    <p>Rating: {{ $comment->rating }} / 5</p>
                @endif
                <small>Posted on {{ $comment->created_at->format('d M, Y') }}</small>
            </div>
        @endforeach
    </div>

    @if(Auth::check())
        <div class="comment-form">
            <h3>Leave a Comment</h3>
            <form action="{{ url('/products/' . $product->id . '/comment') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="comment" class="form-control" required placeholder="Write your comment..."></textarea>
                </div>
                <div class="form-group">
                    <input type="number" name="rating" class="form-control" min="1" max="5" placeholder="Rating (1-5)">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to comment.</p>
    @endif
</div>

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}
.product-details {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.product-image img {
    max-width: 100%;
    height: auto;
}
.product-info {
    margin-top: 20px;
}
.price {
    font-size: 1.5em;
    color: #28a745;
}
.comments-section {
    margin-top: 40px;
}
.comment {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}
.comment-form {
    margin-top: 20px;
}
.form-group {
    margin-bottom: 15px;
}
</style>
   
@endsection