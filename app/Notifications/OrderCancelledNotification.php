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
    