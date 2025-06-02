<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('broadcast_audits', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->uuid('entity_uuid')->index();
            $table->json('payload');
            $table->timestamp('broadcasted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_audits');
    }
};
