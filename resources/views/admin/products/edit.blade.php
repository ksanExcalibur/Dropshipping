
@extends('layouts.admin-layout')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <h1>Edit Product</h1>

    @if($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('admin.products.update', ['product' => $product]) }}">
        @csrf
        @method('put')
        
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter product name" 
                value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="qty" class="form-control" placeholder="Enter quantity" 
                value="{{ old('qty', $product->qty) }}" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" placeholder="Enter description">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter price" 
                value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" class="form-control" name="image" id="image">
    </div>

        <button type="submit" class="btn btn-primary mt-3">Update Product</button>
    </form>
</div>
@endsection

<style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    body {
        background-color: #f5f5f5;
        padding: 2rem;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    h1 {
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
        font-size: 2rem;
    }

    .error-messages {
        background-color: #fee;
        color: #dc3545;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 5px;
        border: 1px solid #f5c6cb;
    }

    .error-messages ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        color: #555;
        font-weight: 500;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        outline: none;
        border-color: #2196F3;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
    }

    .btn-primary {
        background-color: #4CAF50;
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }
        
        body {
            padding: 1rem;
        }
    }
</style>