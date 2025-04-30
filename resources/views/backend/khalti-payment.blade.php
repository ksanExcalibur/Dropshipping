@extends('layouts.layout')

@section('title', 'Pay with Khalti')

@section('content')
<div class="container">
    <h2>Pay with Khalti</h2>
    <p>Total Amount: Rs. {{ $totalAmount }}</p>

    <button id="payment-button" class="btn btn-success">Pay with Khalti</button>
</div>


@endsection