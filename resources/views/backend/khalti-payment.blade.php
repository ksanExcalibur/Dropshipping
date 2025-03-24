@extends('layouts.layout')

@section('title', 'Pay with Khalti')

@section('content')
<div class="container">
    <h2>Pay with Khalti</h2>
    <p>Total Amount: Rs. {{ $totalAmount }}</p>

    <button id="payment-button" class="btn btn-success">Pay with Khalti</button>
</div>
{{-- 
<script src="https://khalti.com/static/khalti-checkout.js"></script>
<script>
    var config = {
        "publicKey": "{{ config('services.khalti.public_key') }}", 
        "productIdentity": "order_{{ Auth::id() }}",
        "productName": "Order Payment",
        "productUrl": "{{ url('/') }}",
        "paymentPreference": ["KHALTI"],
        "eventHandler": {
            onSuccess(payload) {
                fetch("{{ route('khalti.pay') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        token: payload.token,
                        amount: payload.amount
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Payment Successful!");
                        window.location.href = "{{ route('home') }}";
                    } else {
                        alert("Payment verification failed!");
                    }
                })
                .catch(error => {
                    console.error("Error during payment verification:", error);
                    alert("Payment Failed!");
                });
            },
            onError(error) {
                alert("Payment Error: " + JSON.stringify(error));
            },
            onClose() {
                console.log("Payment closed");
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    document.getElementById("payment-button").onclick = function() {
        checkout.show({ amount: {{ $totalAmount * 100 }} }); // Convert to paisa
    };
</script> --}}

@endsection