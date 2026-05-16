<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who gets this
            $table->string('title');                           // Short heading
            $table->text('message');                           // Full notification text
            $table->string('type');                            // pool_matched, driver_assigned, etc
            $table->string('link')->nullable();                // Where to go when clicked
            $table->boolean('is_read')->default(false);        // Read/unread status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};