@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mt-4">
    <h1>Order Details</h1>
    <table class="table">
        <tr>
            <th>Order ID</th>
            <td>{{ $order->id }}</td>
        </tr>
        <tr>
            <th>Product ID</th>
            <td>{{ $order->product_id }}</td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>{{ $order->qty }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>{{ $order->price }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $order->status }}</td>
        </tr>
    </table>
    <a href="{{ route('vendor.orders.list') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection