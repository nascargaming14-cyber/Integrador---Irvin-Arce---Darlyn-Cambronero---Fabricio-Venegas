<?php

namespace App\Events;

use App\Models\HeaderOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $orderId;
    public string $customerName;
    public float $total;

    public function __construct(HeaderOrder $order)
    {
        $this->orderId      = $order->id;
        $this->customerName = $order->customer->customer_name ?? 'Cliente';
        $this->total         = (float) $order->total;
    }

    public function broadcastOn(): array
    {
        // Canal público: todos los que estén viendo el dashboard lo reciben.
        return [new Channel('dashboard')];
    }

    public function broadcastAs(): string
    {
        return 'new-order';
    }

    public function broadcastWith(): array
    {
        return [
            'order_id'      => $this->orderId,
            'customer_name' => $this->customerName,
            'total'         => $this->total,
        ];
    }
}
