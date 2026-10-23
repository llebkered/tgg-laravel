<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    private function order(OrderStatus $status = OrderStatus::Paid): Order
    {
        return Order::create([
            'order_status_id' => $status,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'total' => 67.00,
        ]);
    }

    public function test_status_is_read_as_the_enum()
    {
        $order = $this->order(OrderStatus::Shipped);

        $this->assertSame(OrderStatus::Shipped, $order->fresh()->order_status_id);
    }

    public function test_order_screen_lists_every_status_with_the_current_one_selected()
    {
        $order = $this->order(OrderStatus::Paid);

        $response = $this->get(route('backend.orders.edit', $order->id))->assertOk();

        foreach (OrderStatus::cases() as $status) {
            $response->assertSee($status->label());
        }
        $response->assertSee('<option value="3" selected', false);
        $response->assertDontSee('<option value="1" selected', false);
    }

    public function test_order_list_shows_the_status_name()
    {
        $this->order(OrderStatus::OnHold);

        $this->get(route('backend.orders.index'))->assertOk()->assertSee('On Hold');
    }

    public function test_staff_can_change_the_status()
    {
        $order = $this->order(OrderStatus::Paid);

        $this->put(route('backend.orders.update', $order->id), ['order_status_id' => OrderStatus::Shipped->value])
            ->assertSessionHas('success_message');

        $this->assertSame(OrderStatus::Shipped, $order->fresh()->order_status_id);
    }

    public function test_unknown_status_is_rejected()
    {
        $order = $this->order(OrderStatus::Paid);

        $this->put(route('backend.orders.update', $order->id), ['order_status_id' => 99])
            ->assertSessionHasErrors('order_status_id');

        $this->assertSame(OrderStatus::Paid, $order->fresh()->order_status_id);
    }
}
