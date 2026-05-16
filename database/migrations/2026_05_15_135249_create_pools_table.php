<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pools', function (Blueprint $table) {
            $table->id();
            $table->string('pool_code')->unique();              // Unique code like POOL-2024-001
            $table->string('destination_market');              // Common destination
            $table->string('pickup_region');                   // Common pickup area
            $table->date('pickup_date');                       // Shared pickup date
            $table->decimal('total_capacity_kg', 10, 2);       // Total truck capacity
            $table->decimal('used_capacity_kg', 10, 2)->default(0); // How much is filled
            $table->decimal('total_cost', 10, 2)->nullable();  // Full truck cost
            $table->integer('max_farmers')->default(5);        // Max farmers in pool
            $table->enum('status', [
                'open',         // Accepting new farmers
                'full',         // No more space
                'assigned',     // Driver assigned
                'in_transit',   // On the way
                'completed',    // Delivered
                'cancelled'
            ])->default('open');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('matched_at')->nullable();       // When pool was formed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pools');
    }
};