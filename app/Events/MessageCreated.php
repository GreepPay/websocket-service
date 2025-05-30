<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

/**
 * Fired when a chat/message is posted inside a conversation.
 * Broadcast name: message.created
 */
class MessageCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    /** Conversation (or thread) ID used in channel name */
    public function __construct(
        public string $conversationId,
        public array  $payload        // { message_id, sender_id, body, … }
    ) {}

    /** Private channel: message.{conversationId} */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("message.{$this->conversationId}");
    }

    /** Client listens for “message.created” */
    public function broadcastAs(): string
    {
        return 'message.created';
    }

    /** Raw payload forwarded to socket clients */
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
