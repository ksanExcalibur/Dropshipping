@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="dashboard-content">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}</h2>

    <div class="card p-4 shadow-sm mb-4">
        <h5 class="mb-3">Quick Actions</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('vendor.products.index') }}" class="btn btn-primary">
                <i class="fas fa-box"></i> Manage Products
            </a>
            <a href="{{ route('vendor.orders.list') }}" class="btn btn-secondary">
                <i class="fas fa-shopping-cart"></i> View Orders
            </a>
           
            </a>
        </div>
    </div>

    <div class="card p-4 shadow-sm">
        <h5>Dashboard Overview</h5>
        <p>You can manage your products and track your orders from this panel.</p>
    </div>
</div>
@endsection
