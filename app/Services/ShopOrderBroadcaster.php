<?php

namespace App\Services;

use App\Events\ShopOrderCreated;
use App\Events\ShopOrderUpdated;

class ShopOrderBroadcaster
{
    /**
     * Broadcast a “created” event when a new shop order is placed.
     *
     * @param  string  $uuid   The order identifier.
     * @param  array   $data   Full payload forwarded to the client.
     *
     * @return void
     */
    public function created(string $uuid, array $data): void
    {
        event(new ShopOrderCreated($uuid, $data));
    }

    /**
     * Broadcast an “updated” event when an existing order
     * changes state (e.g. shipped, delivered).
     *
     * @param  string  $uuid   The order identifier.
     * @param  array   $data   Diff or full snapshot of the update.
     *
     * @return void
     */
    public function updated(string $uuid, array $data): void
    {
        event(new ShopOrderUpdated($uuid, $data));
    }
}
