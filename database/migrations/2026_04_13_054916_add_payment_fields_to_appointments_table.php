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
            $table->decimal('amount', 10, 2)->default(0.00)->after('service');
            $table->string('payment_status')->default('pending')->after('amount'); // pending, paid, failed
            $table->string('razorpay_order_id')->nullable()->after('payment_status');
            $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['amount', 'payment_status', 'razorpay_order_id', 'razorpay_payment_id']);
        });
    }
};
