@extends('layouts.layout')

@section('title', 'Your Cart')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Your Cart</h1>
    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($cartItems->isEmpty())
        <p class="text-center">Your cart is empty.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ $item->product->name }}</h5>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rs. {{ $item->product->price }}</td>
                        <td>Rs. {{ $item->product->price * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('checkout.show') }}" class="btn btn-primary btn-lg">Proceed to Checkout</a>
        </div>
    @endif
</div>
@endsection

<style>
    .container {
        max-width: 1200px;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .img-thumbnail {
        border: none;
        border-radius: 5px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>