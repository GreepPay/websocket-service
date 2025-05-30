<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired whenever a transaction changes state
 * (e.g. success, failed, reversed).
 * Broadcast name: transaction.updated
 */
class TransactionUpdated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** UUID that identifies the transaction / channel suffix */
    public function __construct(
        public string $transactionUuid,
        public array  $payload
    ) {}

    /** Private channel: transaction.{uuid} */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("transaction.{$this->transactionUuid}");
    }

    /** Client receives event as “transaction.updated” */
    public function broadcastAs(): string
    {
        return 'transaction.updated';
    }

    /** Data that front-end consumes */
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
