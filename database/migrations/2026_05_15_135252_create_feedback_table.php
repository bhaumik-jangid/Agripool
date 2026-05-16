<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who submitted
            $table->foreignId('shipment_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('rating')->nullable();             // 1 to 5 stars
            $table->string('subject')->nullable();             // Complaint subject
            $table->text('message');                           // Feedback content
            $table->enum('type', ['complaint', 'rating', 'suggestion'])->default('rating');
            $table->enum('status', ['open', 'reviewed', 'resolved'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};