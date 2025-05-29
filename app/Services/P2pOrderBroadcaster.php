<?php

namespace App\Services;

use App\Events\P2pOrderCreated;
use App\Events\P2pOrderUpdated;
use App\Events\P2pOrderMessageCreated;

class P2pOrderBroadcaster
{
    /**
     * Broadcast a “created” event when a new P2P order is opened.
     *
     * @param  string  $uuid   The order identifier.
     * @param  array   $data   Full payload forwarded to the client.
     *
     * @return void
     */
    public function created(string $uuid, array $data): void
    {
        event(new P2pOrderCreated($uuid, $data));
    }

    /**
     * Broadcast an “updated” event when an existing order
     * changes state (paid, released, cancelled, etc.).
     *
     * @param  string  $uuid   The order identifier.
     * @param  array   $data   Diff or full snapshot of the update.
     *
     * @return void
     */
    public function updated(string $uuid, array $data): void
    {
        event(new P2pOrderUpdated($uuid, $data));
    }

    /**
     * Broadcast a “message” event when either participant
     * (or a bot) sends a chat/message inside the order.
     *
     * @param  string  $uuid   The order identifier.
     * @param  array   $data   { message_id, sender_id, body, sent_at, … }.
     *
     * @return void
     */
    public function message(string $uuid, array $data): void
    {
        event(new P2pOrderMessageCreated($uuid, $data));
    }
}
