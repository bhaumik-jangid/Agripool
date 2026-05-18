<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->string('destination_state')
                  ->nullable()
                  ->after('destination_district');
        });
    }

    public function down(): void
    {
        Schema::table('transport_requests', function (Blueprint $table) {
            $table->dropColumn('destination_state');
        });
    }
};