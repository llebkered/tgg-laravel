<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderSortTest extends TestCase
{
    use RefreshDatabase;

    private array $ids;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());

        // Ids run 1-3; names, dates and statuses each in a different order
        $this->ids = [
            'Bea' => $this->order('Bea Customer', '2024-03-01', OrderStatus::Shipped),
            'Al' => $this->order('Al Customer', '2025-01-01', OrderStatus::Paid),
            'Cy' => $this->order('Cy Customer', '2023-06-01', OrderStatus::Cancelled),
        ];
    }

    private function order($name, $date, OrderStatus $status)
    {
        $order = Order::create(['name' => $name, 'order_status_id' => $status]);
        $order->forceFill(['created_at' => $date])->save();

        return $order->id;
    }

    private function assertNamesInOrder($url, array $names)
    {
        $this->get($url)->assertOk()->assertSeeInOrder(
            array_map(fn ($name) => "$name Customer", $names)
        );
    }

    public function test_orders_are_newest_first_by_default()
    {
        $this->assertNamesInOrder('/backend/orders', ['Cy', 'Al', 'Bea']);
    }

    public function test_orders_sort_by_each_column()
    {
        $this->assertNamesInOrder('/backend/orders?sort=id&direction=asc', ['Bea', 'Al', 'Cy']);
        $this->assertNamesInOrder('/backend/orders?sort=date&direction=desc', ['Al', 'Bea', 'Cy']);
        $this->assertNamesInOrder('/backend/orders?sort=date&direction=asc', ['Cy', 'Bea', 'Al']);
        $this->assertNamesInOrder('/backend/orders?sort=name&direction=asc', ['Al', 'Bea', 'Cy']);
        $this->assertNamesInOrder('/backend/orders?sort=name&direction=desc', ['Cy', 'Bea', 'Al']);
        // Workflow order: Paid, Shipped, Cancelled
        $this->assertNamesInOrder('/backend/orders?sort=status&direction=asc', ['Al', 'Bea', 'Cy']);
    }

    public function test_dashboard_order_list_sorts_too()
    {
        $this->assertNamesInOrder('/backend?sort=name&direction=asc', ['Al', 'Bea', 'Cy']);
    }

    public function test_headings_link_to_sort_and_clicking_again_reverses()
    {
        $response = $this->get('/backend/orders?sort=name&direction=asc');

        // The current column flips; the others start in their natural order
        $response->assertSee('sort=name&amp;direction=desc', false)
            ->assertSee('sort=id&amp;direction=desc', false)
            ->assertSee('sort=date&amp;direction=desc', false)
            ->assertSee('sort=status&amp;direction=asc', false)
            ->assertSee('aria-sort="ascending"', false);
    }

    public function test_unknown_sort_values_fall_back_to_newest_first()
    {
        $this->assertNamesInOrder('/backend/orders?sort=email&direction=sideways', ['Cy', 'Al', 'Bea']);
        $this->assertNamesInOrder('/backend/orders?sort[]=name&direction[]=asc', ['Cy', 'Al', 'Bea']);
    }
}
