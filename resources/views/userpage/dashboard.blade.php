@extends('layouts.user-layout')

@section('title', 'My Profile')

@section('content')
<div class="hero bg-image text-white text-center py-5" style="background-image: url('/images/hero.png');">
  <div class="container">
    <h1 class="display-4">Welcome, {{ Auth::user()->name }}</h1>
    <p class="lead">Manage your profile and settings</p>
  </div>
</div>
<div class="container mt-5">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h3>Profile Information</h3>
    </div>
    <div class="card-body">
      <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
      <p><strong>Address:</strong> {{ Auth::user()->address ?? 'N/A' }}</p>
      <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'N/A' }}</p>
    </div>
  </div>
</div>
@endsection
