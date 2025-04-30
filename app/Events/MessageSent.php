<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('chat.'.$this->message['to_id']);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message['id'],
                'from_id' => $this->message['from_id'],
                'to_id' => $this->message['to_id'],
                'message' => $this->message['message'],
                'created_at' => $this->message['created_at'],
                'from' => [
                    'id' => $this->message['from_id'],
                    'name' => $this->message['from_name']
                ]
            ]
        ];
    }
}