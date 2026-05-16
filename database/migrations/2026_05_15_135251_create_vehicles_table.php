<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The driver who owns it
            $table->string('vehicle_type');                    // Truck, Mini-truck, Tempo
            $table->string('vehicle_number')->unique();        // Registration plate
            $table->string('vehicle_model')->nullable();       // e.g. Tata 407
            $table->decimal('capacity_tonnes', 8, 2);          // How many tonnes it can carry
            $table->integer('manufacture_year')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('insurance_expiry')->nullable();
            $table->boolean('is_verified')->default(false);    // Admin verified the vehicle
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};