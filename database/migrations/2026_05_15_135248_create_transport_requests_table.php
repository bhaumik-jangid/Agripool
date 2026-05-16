<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The farmer
            $table->string('crop_type');                       // What crop (wheat, rice, etc)
            $table->decimal('quantity_kg', 10, 2);             // Weight in kilograms
            $table->string('packaging_type');                  // Bags, crates, loose
            $table->string('pickup_location');                 // Where to pick up from
            $table->string('pickup_district');
            $table->string('pickup_state');
            $table->decimal('pickup_latitude', 10, 7)->nullable();
            $table->decimal('pickup_longitude', 10, 7)->nullable();
            $table->string('destination_market');              // Where it's going
            $table->string('destination_district');
            $table->date('preferred_pickup_date');             // When farmer wants pickup
            $table->time('preferred_pickup_time')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();   // Cost estimate
            $table->decimal('actual_cost', 10, 2)->nullable();      // Real cost after delivery
            $table->enum('status', [
                'pending',      // Just created, looking for pool
                'pooled',       // Added to a pool
                'assigned',     // Driver assigned
                'in_transit',   // Currently being transported
                'delivered',    // Successfully delivered
                'cancelled'     // Cancelled by farmer
            ])->default('pending');
            $table->text('special_instructions')->nullable();  // Any notes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_requests');
    }
};