@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Welcome, Admin!</h1>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Total Products</h5>
                    <h3 class="text-primary">{{ $products->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Total Orders</h5>
                    <h3 class="text-success">{{ $orders->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Total Vendors</h5>
                    <h3 class="text-warning">{{ $vendors->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card p-4 shadow-sm mb-4">
        <h5 class="mb-3">Quick Actions</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-box"></i> Manage Products
            </a>
            <a href="{{ route('admin.orders.history') }}" class="btn btn-outline-secondary">
                <i class="fas fa-shopping-cart"></i> View Orders
            </a>
        </div>
    </div>

  
