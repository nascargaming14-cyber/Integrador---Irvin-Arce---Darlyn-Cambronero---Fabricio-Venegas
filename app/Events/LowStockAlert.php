<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LowStockAlert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $productId;
    public string $productName;
    public float $stock;
    public float $minimumStock;

    public function __construct(Product $product)
    {
        $this->productId    = $product->id;
        $this->productName  = $product->product_name;
        $this->stock        = (float) $product->stock;
        $this->minimumStock = (float) $product->minimum_stock;
    }

    public function broadcastOn(): array
    {
        return [new Channel('dashboard')];
    }

    public function broadcastAs(): string
    {
        return 'low-stock';
    }

    public function broadcastWith(): array
    {
        return [
            'product_id'    => $this->productId,
            'product_name'  => $this->productName,
            'stock'         => $this->stock,
            'minimum_stock' => $this->minimumStock,
        ];
    }
}