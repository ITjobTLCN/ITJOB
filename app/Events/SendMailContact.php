<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMailContact
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $email;
    public $name;
    public $subtitle;
    public $content;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $name, $subtitle, $content)
    {
        $this->email = $email;
        $this->name = $name;
        $this->subtitle = $subtitle;
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
