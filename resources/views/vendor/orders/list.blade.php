@extends('layouts.app')

@section('title', 'Vendor Orders')

@section('content')
<div class="container mt-4">
    <h1>Your Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>No orders found.</p>
    @else
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ 'ORD' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->product_name ?? 'No Product' }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>{{ number_format($order->price, 2) }}</td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning',
                                    'paid_pending_vendor' => 'bg-info',
                                    'paid_confirmed' => 'bg-success',
                                    'cancelled_by_user' => 'bg-danger',
                                    'cancelled_by_vendor' => 'bg-secondary',
                                ];
                                $statusLabel = ucwords(str_replace('_', ' ', $order->status));
                            @endphp
                            <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary' }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td>
@endsection
