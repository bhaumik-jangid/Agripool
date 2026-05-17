<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pool_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')
                  ->constrained('users')->onDelete('cascade');
            $table->decimal('original_cost', 10, 2);  // System calculated cost
            $table->decimal('proposed_cost', 10, 2);  // Driver's price
            $table->text('reason');                   // Why driver wants more
            $table->enum('status', [
                'pending',   // Waiting for farmers to vote
                'accepted',  // Majority accepted
                'declined',  // Majority declined
                'expired',   // 24 hours passed
            ])->default('pending');
            $table->timestamp('expires_at');          // 24 hours from proposal
            $table->timestamps();
        });

        Schema::create('price_proposal_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_proposal_id')
                  ->constrained()->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained()->onDelete('cascade'); // The farmer
            $table->enum('vote', ['accept', 'decline']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_proposal_votes');
        Schema::dropIfExists('price_proposals');
    }
};