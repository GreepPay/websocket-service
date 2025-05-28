<?php

namespace App\Services;

use App\Events\P2pOrderCreated;
use App\Events\P2pOrderUpdated;

class P2pOrderBroadcaster
{
    public function created(string $uuid, array $data): void
    {
        event(new P2pOrderCreated($uuid, $data));
    }

    public function updated(string $uuid, array $data): void
    {
        event(new P2pOrderUpdated($uuid, $data));
    }
}
