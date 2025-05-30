<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired whenever a shop order changes state
 * (processing, shipped, delivered, cancelled, etc.).
 * Broadcast name: shop_order.updated
 */
class ShopOrderUpdated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** UUID that identifies the order / channel suffix */
    public function __construct(
        public string $orderUuid,
        public array  $payload
    ) {}

    /** Private channel: shop_order.{uuid} */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("shop_order.{$this->orderUuid}");
    }

    /** Client receives event as “shop_order.updated” */
    public function broadcastAs(): string
    {
        return 'shop_order.updated';
    }

    /** Data that front-end consumes */
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
