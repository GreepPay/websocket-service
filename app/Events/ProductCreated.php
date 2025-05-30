<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired when a new product is created.
 * Broadcast name: product.created
 */
class ProductCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** @var string UUID for the product / channel suffix */
    public string $productUuid;

    /** @var array  Entire payload forwarded to the client */
    public array $payload;

    /**
     * Constructor – every property must be serialisable.
     *
     * @param  string  $productUuid  Product identifier used in the channel name.
     * @param  array   $payload      Data the front-end will consume.
     */
    public function __construct(string $productUuid, array $payload)
    {
        $this->productUuid = $productUuid;
        $this->payload     = $payload;
    }

    /**
     * Decide which channel the event is broadcast on.
     * Always a private channel:  product.{uuid}
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("product.{$this->productUuid}");
    }

    /**
     * Name of the event as received by the client.
     * Makes listener calls explicit:  .listen('product.created', …)
     */
    public function broadcastAs(): string
    {
        return 'product.created';
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
