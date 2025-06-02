<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastAudit extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'event_name',
        'entity_uuid',
        'payload',
        'broadcasted_at',
    ];

    protected $casts = [
        'payload'        => 'array',
        'broadcasted_at' => 'datetime',
    ];
}
