<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();          // e.g. AGP-TRK-20240001
            $table->foreignId('pool_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', [
                'pickup_pending',   // Driver has not picked up yet
                'cargo_loaded',     // Driver loaded the cargo
                'in_transit',       // Moving to market
                'delivered',        // Reached destination
                'failed'            // Delivery failed
            ])->default('pickup_pending');
            $table->timestamp('pickup_time')->nullable();       // When cargo was loaded
            $table->timestamp('delivery_time')->nullable();     // When delivered
            $table->string('current_location')->nullable();     // Live location text
            $table->text('driver_notes')->nullable();           // Driver's notes
            $table->decimal('total_distance_km', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};