<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dropshipping Receipt</title>
</head>
<body style="margin: 0; padding: 20px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; background-color: #f8fafc; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <!-- Header Bar -->
                    <tr>
                        <td style="background: #6366f1; height: 8px; border-top-left-radius: 8px; border-top-right-radius: 8px;"></td>
                    </tr>
                    
                    <!-- Header Content -->
                    <tr>
                        <td style="padding: 30px 30px 20px;">
                            <h2 style="margin: 0 0 10px; text-align: center; color: #1e293b; font-size: 24px; font-weight: 700;">Order Confirmation</h2>
                            <p style="margin: 0; text-align: center; color: #64748b; font-size: 15px;">DROPSHIPPING RECEIPT</p>
                        </td>
                    </tr>

                    <!-- Order Info -->
                    <tr>
                        <td style="padding: 0 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f8fafc; border-radius: 8px; border-left: 4px solid #6366f1; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 5px 0;">
                                                    <strong style="color: #6366f1; min-width: 100px; display: inline-block;">Order ID:</strong>
                                                    <span>{{ 'ORD' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                </td>
                                                <td style="padding: 5px 0;">
                                                    <strong style="color: #6366f1; min-width: 100px; display: inline-block;">Order Date:</strong>
                                                    <span>{{ $order->created_at->format('F j, Y') }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding: 5px 0;">
                                                    <strong style="color: #6366f1; min-width: 100px; display: inline-block;">Status:</strong>
                                                    <span style="background: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 20px; font-size: 13px;">{{ ucfirst($order->status) }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Order Details -->
                    <tr>
                        <td style="padding: 0 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="padding: 8px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6366f1; font-weight: 500;">Customer Name</td>
                                                <td align="right">{{ $order->customer_name }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6366f1; font-weight: 500;">Shipping Address</td>
                                                <td align="right">{{ $order->address }}, {{ $order->city }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6366f1; font-weight: 500;">Product Name</td>
                                                <td align="right">{{ $order->product_name }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6366f1; font-weight: 500;">Quantity</td>
                                                <td align="right">{{ $order->qty }} pcs</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6366f1; font-weight: 500;">Unit Price</td>
                                                <td align="right">Rs.{{ number_format($order->price, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; background-color: #f8fafc; border-radius: 8px; margin-bottom: 10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="color: #6366f1; font-weight: 500;">Shipping Method</td>
                                                <td align="right">📦Shipping in 2 days {{ $order->shipping_method }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Total Amount -->
                    <tr>
                        <td style="padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background: #6366f1; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 20px; color: #ffffff; font-size: 20px; font-weight: 700;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>Total Amount</td>
                                                <td align="right">Rs.{{ number_format($order->price, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px; text-align: center; color: #64748b;">
                            <p style="margin: 0 0 10px; color: #1e293b; font-weight: 500;">Thank you for choosing us!</p>
                            <p style="margin: 0 0 10px;">✉️ support@yourdropshipping.com | 📞 123-456-7890</p>
                            <p style="margin: 10px 0 0; font-size: 13px; color: #94a3b8;">
                                Order ID: {{ 'ORD' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }} • {{ date('Y') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>