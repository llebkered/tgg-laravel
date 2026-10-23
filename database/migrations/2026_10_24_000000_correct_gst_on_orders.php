<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Orders placed before October 2026 stored 1/10 of the total as GST. Prices
     * include GST, so it is 1/11. Correct gst on those orders and keep the
     * figure their invoices showed in gst_as_invoiced. gst_as_invoiced is null
     * where the invoice showed the gst column as it is.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('gst_as_invoiced', 10, 2)->nullable()->after('gst');
        });

        DB::table('orders')
            ->whereNotNull('total')
            ->orderBy('id')
            ->each(function ($order) {
                $gst = Order::gstIncluded($order->total);

                if ($order->gst !== null && abs($order->gst - $gst) < 0.005) {
                    return;
                }

                DB::table('orders')->where('id', $order->id)->update([
                    'gst_as_invoiced' => $order->gst,
                    'gst' => $gst,
                ]);
            });
    }

    public function down(): void
    {
        DB::table('orders')
            ->whereNotNull('gst_as_invoiced')
            ->update(['gst' => DB::raw('gst_as_invoiced')]);

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('gst_as_invoiced');
        });
    }
};
