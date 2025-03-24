@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1>Welcome to Admin Dashboard</h1>

    <!-- Quick Actions -->
    <div class="card p-4 shadow-sm mb-4">
        <h5 class="mb-3">Quick Actions</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                <i class="fas fa-box"></i> Manage Products
            </a>
            <a href="{{ route('admin.orders.history') }}" class="btn btn-secondary">
                <i class="fas fa-shopping-cart"></i> View Orders
            </a>
        </div>
    </div>

    <!-- Product Management -->
    <h2 class="my-4">Products</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h4>Product List</h4>
        </div>
        <div class="card-body">
            @include('admin.products.index') <!-- Make sure this view is properly rendering the list of products -->
        </div>
    </div>

    <!-- Order Management -->
    <h2 class="my-4">Orders</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h4>Order List</h4>
        </div>
        <div class="card-body">
            @include('admin.orders.history') <!-- This should include a list of orders with details -->
        </div>
    </div>
</div>
@endsection
