<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * payment_started_at is set when a card payment starts, so only one
     * request can charge an order. charge_token is Pin's charge reference.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('payment_started_at')->nullable()->after('total');
            $table->string('charge_token')->nullable()->after('payment_started_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_started_at', 'charge_token']);
        });
    }
};
