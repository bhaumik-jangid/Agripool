<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pool_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pool_id')->constrained()->onDelete('cascade');
            $table->foreignId('transport_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The farmer
            $table->decimal('share_percentage', 5, 2)->nullable(); // Their % of the truck
            $table->decimal('cost_share', 10, 2)->nullable();      // Their portion of total cost
            $table->boolean('cost_paid')->default(false);
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pool_members');
    }
};