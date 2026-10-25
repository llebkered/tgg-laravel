<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Record how each order is paid: 'card' or 'direct_deposit'. Existing
     * orders are filled in where it can be told: a Pin charge token means
     * card, and an Invoiced order (status 2) is waiting for a direct deposit.
     * Other older orders stay null, shown to staff as unknown.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('charge_token');
        });

        DB::table('orders')->whereNotNull('charge_token')->update(['payment_method' => 'card']);
        DB::table('orders')->whereNull('payment_method')->where('order_status_id', 2)->update(['payment_method' => 'direct_deposit']);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};
