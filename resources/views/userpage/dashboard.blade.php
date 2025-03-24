@extends('layouts.user-layout')

@section('title', 'My Profile')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>Welcome, {{ Auth::user()->name }}</h3>
  </div>
  <div class="card-body">
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    <p><strong>Address:</strong> {{ Auth::user()->address ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'N/A' }}</p>
  </div>
</div>
@endsection
