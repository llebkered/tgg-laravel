<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Http\Middleware\AdminAccessMiddleware;
use App\Mail\OrderShippedMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class OrderShippedEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // The admin check needs users.role_id and a roles table, which the
        // migrations don't create, so sign in and skip it.
        $this->withoutMiddleware(AdminAccessMiddleware::class);
        $this->actingAs(User::factory()->create());
    }

    private function order(): Order
    {
        return Order::create([
            'order_status_id' => OrderStatus::Paid,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'line1' => '1 Main St',
            'city' => 'Melbourne',
            'postcode' => '3000',
            'total' => 100.00,
            'cart' => json_encode(['row1' => ['name' => 'Farm Pack', 'qty' => 1, 'price' => 100, 'subtotal' => '100.00']]),
        ]);
    }

    public function test_preview_shows_the_order()
    {
        $order = $this->order();

        $this->get(route('backend.orders.sendshippedemail', $order->id))
            ->assertOk()
            ->assertSee('Farm Pack')
            ->assertSee('GST: $9.09', false);
    }

    public function test_sending_saves_the_tracking_and_emails_the_customer()
    {
        Mail::fake();
        $order = $this->order();

        $this->post(route('backend.orders.sendshippedemail', $order->id), [
            'tracking' => 'AP123456',
            'message' => '<p>Thanks for your order</p>',
        ])->assertRedirect(route('backend.orders.edit', $order->id))
            ->assertSessionHas('success_message');

        $order->refresh();
        $this->assertSame('AP123456', $order->tracking);
        $this->assertSame('<p>Thanks for your order</p>', $order->message);

        Mail::assertSent(OrderShippedMail::class, function (OrderShippedMail $mail) use ($order) {
            return $mail->order->is($order)
                && $mail->hasTo('john@test.com', 'John Doe')
                && $mail->hasBcc('sales@toadgully.com.au')
                && $mail->hasFrom('sales@toadgully.com.au', 'Toad Gully Growers')
                && $mail->hasSubject('Order from Toad Gully Growers has been shipped');
        });
    }

    public function test_email_shows_the_tracking_number_and_message()
    {
        $order = $this->order();
        $order->update(['tracking' => 'AP123456', 'message' => '<p>Thanks for your order</p>']);

        (new OrderShippedMail($order->fresh()))
            ->assertSeeInHtml('AP123456')
            ->assertSeeInHtml('<p>Thanks for your order</p>', false)
            ->assertSeeInHtml('Farm Pack');
    }

    public function test_failed_email_tells_staff()
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('mail server down'));
        $order = $this->order();

        $this->post(route('backend.orders.sendshippedemail', $order->id), ['tracking' => 'AP123456'])
            ->assertRedirect(route('backend.orders.sendshippedemail', $order->id))
            ->assertSessionHas('danger_message', 'The shipped email could not be sent: mail server down');

        $this->assertSame('AP123456', $order->fresh()->tracking);
    }

    public function test_unknown_order_is_not_found()
    {
        $this->get(route('backend.orders.sendshippedemail', 999))->assertNotFound();
        $this->post(route('backend.orders.sendshippedemail', 999))->assertNotFound();
    }
}
