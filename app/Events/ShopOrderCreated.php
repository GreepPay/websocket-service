<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired when a new shop order is created.
 * Broadcast name: shop_order.created
 */
class ShopOrderCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** @var string UUID for the order / channel suffix */
    public string $orderUuid;

    /** @var array  Entire payload forwarded to the client */
    public array $payload;

    /**
     * Constructor – every property must be serialisable.
     *
     * @param  string  $orderUuid  Order identifier used in the channel name.
     * @param  array   $payload    Data the front-end will consume.
     */
    public function __construct(string $orderUuid, array $payload)
    {
        $this->orderUuid = $orderUuid;
        $this->payload   = $payload;
    }

    /**
     * Decide which channel the event is broadcast on.
     * Always a private channel:  shop_order.{uuid}
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("shop_order.{$this->orderUuid}");
    }

    /**
     * Name of the event as received by the client.
     * Makes listener calls explicit:  .listen('shop_order.created', …)
     */
    public function broadcastAs(): string
    {
        return 'shop_order.created';
    }

    /**
     * The actual data sent over the wire.
     * Returning the original payload keeps the event lean.
     */
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
