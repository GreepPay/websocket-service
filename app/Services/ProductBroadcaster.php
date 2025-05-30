<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Events\ProductUpdated;

class ProductBroadcaster
{
    /**
     * Broadcast a “created” event when a new product is added.
     *
     * @param  string  $uuid   The product identifier.
     * @param  array   $data   Full payload forwarded to the client.
     *
     * @return void
     */
    public function created(string $uuid, array $data): void
    {
        event(new ProductCreated($uuid, $data));
    }

    /**
     * Broadcast an “updated” event when an existing product
     * changes state (e.g. price, stock).
     *
     * @param  string  $uuid   The product identifier.
     * @param  array   $data   Diff or full snapshot of the update.
     *
     * @return void
     */
    public function updated(string $uuid, array $data): void
    {
        event(new ProductUpdated($uuid, $data));
    }
}
