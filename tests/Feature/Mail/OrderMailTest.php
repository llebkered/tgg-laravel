<?php

namespace Tests\Feature\Mail;

use App\Mail\OrderInvoiceMail;
use App\Mail\OrderPaidMail;
use App\Mail\PaymentUnconfirmedMail;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderMailTest extends TestCase
{
    use RefreshDatabase;

    private function order(): Order
    {
        return Order::create([
            'order_status_id' => 3,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'line1' => '1 Main St',
            'city' => 'Melbourne',
            'postcode' => '3000',
            'total' => 110.00,
            'gst' => 10.00,
            'cart' => json_encode(['row1' => ['name' => 'Farm Pack', 'qty' => 1, 'price' => 110, 'subtotal' => '110.00']]),
        ])->fresh();
    }

    private function assertPdfAttached($mail): void
    {
        $attachments = $mail->attachments();
        $this->assertCount(1, $attachments);

        $attachments[0]->attachWith(
            fn () => $this->fail('Expected the PDF to be attached as data'),
            function ($data, $attachment) {
                $this->assertSame('invoice.pdf', $attachment->as);
                $this->assertSame('application/pdf', $attachment->mime);
                $this->assertStringStartsWith('%PDF', $data());
            }
        );
    }

    public function test_paid_email_lists_the_order_and_attaches_a_pdf()
    {
        $order = $this->order();
        $mail = new OrderPaidMail($order);

        $mail->assertHasSubject('Toad Gully Growers Invoice');
        $mail->assertSeeInHtml('Your order number is: ' . $order->id);
        $mail->assertSeeInHtml('Farm Pack');
        $mail->assertSeeInHtml('1 Main St');

        $this->assertPdfAttached($mail);
    }

    public function test_invoice_email_lists_the_order_and_attaches_a_pdf()
    {
        $order = $this->order();
        $mail = new OrderInvoiceMail($order);

        $mail->assertSeeInHtml('Please include your order number (' . $order->id . ')');
        $mail->assertSeeInHtml('Farm Pack');
        $this->assertPdfAttached($mail);
    }

    public function test_payment_unconfirmed_email_tells_staff_which_order_to_check()
    {
        $order = $this->order();
        $mail = new PaymentUnconfirmedMail($order, '502 {"error":"gateway_error"}');

        $mail->assertHasSubject('Check card payment for order ' . $order->id);
        $mail->assertSeeInText('John Doe, john@test.com, $110.00');
        $mail->assertSeeInText('Pin response: 502 {"error":"gateway_error"}');
    }
}
