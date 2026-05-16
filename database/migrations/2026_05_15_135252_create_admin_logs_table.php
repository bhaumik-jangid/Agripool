<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Which admin
            $table->string('action');                          // What they did
            $table->string('target_type')->nullable();         // What type of record affected
            $table->unsignedBigInteger('target_id')->nullable(); // Which record ID
            $table->text('description')->nullable();           // Human readable description
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};