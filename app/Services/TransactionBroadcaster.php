<?php

namespace App\Services;

use App\Events\TransactionCreated;
use App\Events\TransactionUpdated;

class TransactionBroadcaster
{
    /**
     * Broadcast a “created” event when a new transaction is initiated.
     *
     * @param  string  $uuid   The transaction identifier.
     * @param  array   $data   Full payload forwarded to the client.
     *
     * @return void
     */
    public function created(string $uuid, array $data): void
    {
        event(new TransactionCreated($uuid, $data));
    }

    /**
     * Broadcast an “updated” event when a transaction status changes.
     *
     * @param  string  $uuid   The transaction identifier.
     * @param  array   $data   Diff or full snapshot of the update.
     *
     * @return void
     */
    public function updated(string $uuid, array $data): void
    {
        event(new TransactionUpdated($uuid, $data));
    }
}
