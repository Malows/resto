<?php

namespace App\Events;

use App\Pedido;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class despacharPedido implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pedido;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('pedidos');
    }

    public function broadcastAs()
    {
        return 'despacharPedido';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->pedido->id,
            'mesa' => $this->pedido->mesa,
            'mozo' => $this->pedido->user_id,
            'platos' => $this->pedido->platos
        ];
    }
}
