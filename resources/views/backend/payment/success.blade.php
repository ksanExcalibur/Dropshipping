<!-- resources/views/payment/success.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
</head>
<body>
    <h1>Payment Successful!</h1>
    <p>Your order has been successfully processed.</p>
    <p>Amount: {{ $amount }}</p>
    <p>Order ID: {{ 'ORD' . str_pad($latestOrder->id, 5, '0', STR_PAD_LEFT) }}</p>

</body>
</html>
