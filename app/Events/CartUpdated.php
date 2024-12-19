<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CartUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cartItems;

    public function __construct($cartItems)
    {
        $this->cartItems = $cartItems;
    }

    public function broadcastOn()
    {
        return new Channel('cart-channel');
    }

    public function broadcastAs()
    {
        return 'cart-updated';
    }
}
