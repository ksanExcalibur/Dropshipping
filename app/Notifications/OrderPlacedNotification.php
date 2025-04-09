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

}
