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
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('service');
            $table->decimal('advance_paid', 10, 2)->default(0.00)->after('total_amount');
            $table->string('final_payment_status')->default('pending')->after('payment_status'); // pending, paid
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'advance_paid', 'final_payment_status']);
        });
    }
};
