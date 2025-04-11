<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    public $order;

    // Accept order when notification is created
    public function __construct($order)
    {
        $this->order = $order;
    }

    // Choose how to deliver this notification
    public function via($notifiable)
    {
        return ['database']; // You can also add 'mail' here
    }

   // What will be saved in the database
// What will be saved in the database
public function toDatabase($notifiable)
{
    if ($notifiable->isUser()) {  // Check if the notifiable is a user
        // User-specific message
        return [
            'title' => 'New Order Placed',
            'message' => 'Your order #' . $this->order->id .
             ' has been successfully placed for ' . $this->order->product->name,
            'order_id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'user_name' => $this->order->user->name,
            'vendor_id' => $this->order->vendor_id,
            'product_name' => $this->order->product->name,
        ];
    } else {
        // Admin and Vendor share the same message
        return [
            'title' => 'New Order Placed',
            'message' => 'Order #' . $this->order->id .
             ' has been placed by ' . $this->order->user->name . ' for ' . $this->order->product->name,
            'order_id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'user_name' => $this->order->user->name,
            'vendor_id' => $this->order->vendor_id,
            'product_name' => $this->order->product->name,
        ];
    }
}



}
