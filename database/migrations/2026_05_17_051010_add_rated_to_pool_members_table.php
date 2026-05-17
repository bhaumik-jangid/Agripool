<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pool_members', function (Blueprint $table) {
            $table->integer('driver_rating')->nullable()->after('cost_paid');
            $table->text('rating_comment')->nullable()->after('driver_rating');
            $table->boolean('has_rated')->default(false)->after('rating_comment');
        });
    }

    public function down(): void
    {
        Schema::table('pool_members', function (Blueprint $table) {
            $table->dropColumn(['driver_rating', 'rating_comment', 'has_rated']);
        });
    }
};