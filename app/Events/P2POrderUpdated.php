<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class P2pOrderUpdated implements ShouldBroadcastNow
{
    use SerializesModels;

    public function __construct(
        public string $orderUuid,
        public array  $payload
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("p2p-order.$this->orderUuid");
    }

    public function broadcastAs(): string   { return 'updated'; }
    public function broadcastWith(): array  { return $this->payload; }
}
