<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired whenever a product changes state
 * (price, stock, visibility, etc.).
 * Broadcast name: product.updated
 */
class ProductUpdated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** UUID that identifies the product / channel suffix */
    public function __construct(
        public string $productUuid,
        public array  $payload
    ) {}

    /** Private channel: product.{uuid} */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("product.{$this->productUuid}");
    }

    /** Client receives event as “product.updated” */
    public function broadcastAs(): string
    {
        return 'product.updated';
    }

    /** Data that front-end consumes */
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
