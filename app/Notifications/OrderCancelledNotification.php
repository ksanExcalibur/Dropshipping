<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderCancelledNotification extends Notification
{
    use Queueable;

    public $order;

    // Accept order when notification is created
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Choose how to deliver this notification
    public function via($notifiable)
    {
        return ['database']; // You can also add 'mail' here if needed
    }

    // What will be saved in the database
    public function toDatabase($notifiable)
    {
        if ($notifiable->isUser()) {  // Check if the notifiable is a user
            // User-specific message
            return [
                'title' => 'Order Cancelled',
                'message' => 'Your order #' . $this->order->id . ' has been cancelled. Reason: ' . 
                    ($this->order->status == 'cancelled_by_user' ? 'Cancelled by You' : 'Cancelled by Vendor'),
                'order_id' => $this->order->id,
                'user_id' => $this->order->user_id,
                'user_name' => $this->order->user->name ?? 'Unknown User', // Avoid null errors
                'vendor_id' => $this->order->vendor_id,
                'product_name' => $this->order->product_name,
            ];
        } else {
            // Admin and Vendor share the same message
            return [
                'title' => 'Order Cancelled',
                'message' => 'Order #' . $this->order->id . ' placed by ' . $this->order->user->name .
                    ' has been cancelled. Reason: ' . ($this->order->status == 'cancelled_by_user' ? 'Cancelled by User' : 'Cancelled by Vendor'),
                'order_id' => $this->order->id,
                'user_id' => $this->order->user_id,
                'user_name' => $this->order->user->name ?? 'Unknown User', // Avoid null errors
                'vendor_id' => $this->order->vendor_id,
                'product_name' => $this->order->product_name,
            ];
        }
    }
}
