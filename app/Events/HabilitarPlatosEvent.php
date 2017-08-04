<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class HabilitarPlatosEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $platos;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($platos)
    {
        $this->platos = $platos;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('platos');
    }

    public function broadcastAs()
    {
        return 'habilitarPlatos';
    }

    public function broadcastWith()
    {
        return $this->platos;
    }

    public function broadcastWhen()
    {
        return boolval( count( $this->platos ) );
    }
}
