<!-- resources/views/userpage/orders.blade.php -->
@extends('layouts.user-layout')

@section('title', 'My Orders')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>My Order History</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped">
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
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->qty }}</td>
                    <td>{{ number_format($order->price, 2) }}</td>
                    <td>
                        <span class="badge
                            @if($order->status == 'pending') bg-warning
                            @elseif($order->status == 'paid') bg-success
                            @else bg-secondary @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                       <a href="{{ route('orders.receipt', $order->id) }}" class="btn btn-primary btn-sm">View Receipt</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection