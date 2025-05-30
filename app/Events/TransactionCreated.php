<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired when a new transaction is created.
 * Broadcast name: transaction.created
 */
class TransactionCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** @var string UUID for the transaction / channel suffix */
    public string $transactionUuid;

    /** @var array  Entire payload forwarded to the client */
    public array $payload;

    /**
     * Constructor – every property must be serialisable.
     *
     * @param  string  $transactionUuid  Transaction identifier used in the channel name.
     * @param  array   $payload          Data the front-end will consume.
     */
    public function __construct(string $transactionUuid, array $payload)
    {
        $this->transactionUuid = $transactionUuid;
        $this->payload         = $payload;
    }

    /**
     * Decide which channel the event is broadcast on.
     * Always a private channel:  transaction.{uuid}
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("transaction.{$this->transactionUuid}");
    }

    /**
     * Name of the event as received by the client.
     * Makes listener calls explicit:  .listen('transaction.created', …)
     */
    public function broadcastAs(): string
    {
        return 'transaction.created';
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
