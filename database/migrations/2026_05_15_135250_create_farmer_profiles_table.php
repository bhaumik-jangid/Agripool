<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
            $table->string('farm_name')->nullable();           // Name of their farm
            $table->string('farm_location');                   // Village/area of farm
            $table->string('district');                        // District
            $table->string('state');                           // State
            $table->string('pincode', 10)->nullable();         // Postal code
            $table->decimal('latitude', 10, 7)->nullable();    // GPS latitude
            $table->decimal('longitude', 10, 7)->nullable();   // GPS longitude
            $table->text('bio')->nullable();                   // Short description
            $table->integer('total_shipments')->default(0);    // Count of completed shipments
            $table->decimal('rating', 3, 2)->default(0.00);   // Average rating received
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmer_profiles');
    }
};