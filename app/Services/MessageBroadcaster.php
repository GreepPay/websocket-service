<?php

namespace App\Services;

use App\Events\MessageCreated;

/**
 * Publishes chat/message events.
 * Each message is scoped to its conversation thread.
 */
class MessageBroadcaster
{
    /**
     * Broadcast a “message.created” event when a new chat
     * message is sent in a conversation.
     *
     * @param  string  $conversationId  Channel suffix: message.{conversationId}
     * @param  array   $data            { message_id, sender_id, body, sent_at, … }
     *
     * @return void
     */
    public function created(string $conversationId, array $data): void
    {
        event(new MessageCreated($conversationId, $data));
    }
}
