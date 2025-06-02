<?php

namespace App\Listeners;

use App\Models\BroadcastAudit;

class LogBroadcastEvent
{
    /**
     * Handle any ShouldBroadcastNow event.
     */
    public function handle(object $event): void
    {
        // ✓ event must implement broadcastAs() and broadcastWith()
        BroadcastAudit::create([
            'event_name'     => $event->broadcastAs(),
            'entity_uuid'    => $this->extractUuid($event),
            'payload'        => $event->broadcastWith(),
            'broadcasted_at' => now(),
        ]);
    }

    /**
     * Pick the first property that ends with "Uuid"
     * (orderUuid, productUuid, txUuid, conversationId, …).
     */
    private function extractUuid(object $event): string
    {
        foreach (get_object_vars($event) as $key => $value) {
            if (str_ends_with($key, 'Uuid') || str_ends_with($key, 'Id')) {
                return (string) $value;
            }
        }
        return 'n/a';
    }
}
