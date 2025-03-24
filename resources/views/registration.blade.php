@extends('layouts.layout')

@section('title', 'Registration')

@section('content')
<div class="container">
    <div class="mt-5">
        @if($errors->any())
            <div class="col-12">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    <form action="{{ route('registration.post') }}" method="POST" class="ms-auto me-auto mt-auto" style="width:500px">
        @csrf
        <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullName" name="fullName" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Register As</label>
            <select class="form-select" id="role" name="role">
                <option value="user" selected>User</option>
                <option value="vendor">Vendor</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="admin_code" class="form-label">Admin Code (Optional)</label>
            <input type="text" class="form-control" id="admin_code" name="admin_code" placeholder="Enter admin code if applicable">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection
