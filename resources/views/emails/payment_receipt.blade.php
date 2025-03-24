<!-- resources/views/emails/payment_receipt.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .receipt { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #333; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        .footer { text-align: center; margin-top: 20px; color: #777; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>Payment Receipt</h2>
        </div>
        <div class="details">
            <p><strong>Order ID:</strong> {{ 'ORD' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Product Name:</strong> {{ $order->product_name }}</p>
            <p><strong>Quantity:</strong> {{ $order->qty }}</p>
            <p><strong>Total Price:</strong> {{ number_format($order->price, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->pincode }}</p>
        </div>
        <div class="footer">
            <p>Thank you for your purchase!</p>
        </div>
    </div>
</body>
</html>