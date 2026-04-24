<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('pickup_address')->nullable()->after('workshop_name');
            $table->decimal('user_lat', 10, 8)->nullable()->after('pickup_address');
            $table->decimal('user_lng', 11, 8)->nullable()->after('user_lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['pickup_address', 'user_lat', 'user_lng']);
        });
    }
};
