@extends('layouts.admin-layout')

@section('title', 'Admin Orders')

@section('content')
    <h3>Orders History</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Payment Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ 'ORD' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->user ? $order->user->name : 'Unknown' }}</td>
                <td>{{ $order->product ? $order->product->name : 'No Product' }}</td>
                <td>{{ $order->qty }}</td>
                <td>{{ number_format($order->price, 2) }}</td>
                <td>
                    <span class=" badge-dark
                        @if($order->status == 'pending') badge-warning
                        @elseif($order->status == 'paid') badge-success
                        @else badge-secondary @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>
                    <strong>Payment Amount:</strong> Rs. {{ number_format($order->price, 2) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
