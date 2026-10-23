<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CorrectGstMigrationTest extends TestCase
{
    use RefreshDatabase;

    private function migration()
    {
        return require database_path('migrations/2026_10_24_000000_correct_gst_on_orders.php');
    }

    private function order($total, $gst)
    {
        return DB::table('orders')->insertGetId([
            'order_status_id' => 4,
            'total' => $total,
            'gst' => $gst,
        ]);
    }

    public function test_old_orders_get_the_correct_gst_and_keep_the_invoiced_figure()
    {
        $migration = $this->migration();
        $migration->down();

        $old = $this->order(110, 11.00);
        $oldWithCents = $this->order(229, 22.90);
        $new = $this->order(229, 20.82);
        $noTotal = $this->order(null, null);

        $migration->up();

        $orders = DB::table('orders')->get()->keyBy('id');

        $this->assertEquals(10.00, $orders[$old]->gst);
        $this->assertEquals(11.00, $orders[$old]->gst_as_invoiced);

        $this->assertEquals(20.82, $orders[$oldWithCents]->gst);
        $this->assertEquals(22.90, $orders[$oldWithCents]->gst_as_invoiced);

        // Already correct, so its invoice showed gst as it is
        $this->assertEquals(20.82, $orders[$new]->gst);
        $this->assertNull($orders[$new]->gst_as_invoiced);

        $this->assertNull($orders[$noTotal]->gst);
        $this->assertNull($orders[$noTotal]->gst_as_invoiced);
    }

    public function test_rolling_back_restores_the_invoiced_gst()
    {
        $migration = $this->migration();
        $migration->down();
        $old = $this->order(110, 11.00);
        $new = $this->order(229, 20.82);
        $migration->up();

        $migration->down();

        $this->assertEquals(11.00, DB::table('orders')->where('id', $old)->value('gst'));
        $this->assertEquals(20.82, DB::table('orders')->where('id', $new)->value('gst'));
    }
}
