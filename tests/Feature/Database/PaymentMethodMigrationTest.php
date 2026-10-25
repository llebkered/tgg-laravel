<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PaymentMethodMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_orders_get_a_payment_method_where_it_can_be_told()
    {
        $migration = require database_path('migrations/2026_10_25_000000_add_payment_method_to_orders_table.php');
        $migration->down();

        $card = DB::table('orders')->insertGetId(['order_status_id' => 4, 'charge_token' => 'ch_abc']);
        $invoiced = DB::table('orders')->insertGetId(['order_status_id' => 2]);
        $oldShipped = DB::table('orders')->insertGetId(['order_status_id' => 4]);
        $inCart = DB::table('orders')->insertGetId(['order_status_id' => 1]);

        $migration->up();

        $methods = DB::table('orders')->pluck('payment_method', 'id');
        $this->assertSame('card', $methods[$card]);
        $this->assertSame('direct_deposit', $methods[$invoiced]);
        $this->assertNull($methods[$oldShipped]);
        $this->assertNull($methods[$inCart]);
    }
}
