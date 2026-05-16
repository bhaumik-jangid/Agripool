<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('license_number')->unique();         // Driving license number
            $table->string('license_expiry');                   // License expiry date
            $table->string('current_location')->nullable();     // Where driver is now
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->enum('status', ['available', 'on_trip', 'offline'])->default('offline');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->decimal('rating', 3, 2)->default(0.00);    // Average rating from farmers
            $table->integer('total_deliveries')->default(0);    // Completed delivery count
            $table->decimal('total_earnings', 10, 2)->default(0.00); // Lifetime earnings
            $table->text('rejection_reason')->nullable();       // Why admin rejected them
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_profiles');
    }
};