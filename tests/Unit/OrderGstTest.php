<?php

namespace Tests\Unit;

use App\Models\Order;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OrderGstTest extends TestCase
{
    public static function amounts(): array
    {
        // GST-inclusive total => GST included (1/11, to the cent)
        return [
            'exact' => [110, 10.00],
            'Farm Pack' => [100, 9.09],
            'Homestead Pack' => [67, 6.09],
            'Estate Pack' => [229, 20.82],
            'over $1,000' => [1234.50, 112.23],
            'cents' => [0.55, 0.05],
            'zero' => [0, 0.00],
            'string total, as read from the database' => ['1234.50', 112.23],
        ];
    }

    #[DataProvider('amounts')]
    public function test_gst_is_one_eleventh_of_the_total($total, $gst)
    {
        $this->assertSame($gst, Order::gstIncluded($total));
    }

    public function test_order_gst_is_worked_out_from_its_total()
    {
        $order = new Order(['total' => '100.00']);

        $this->assertSame(9.09, $order->gstAmount());
    }

    public function test_order_gst_ignores_a_wrong_stored_value()
    {
        // Orders placed before October 2026 stored 1/10 of the total
        $order = new Order(['total' => '100.00', 'gst' => '10.00']);

        $this->assertSame(9.09, $order->gstAmount());
    }
}
