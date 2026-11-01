<?php

namespace Tests\Feature\Mail;

use App\Enums\PaymentMethod;
use App\Mail\OrderEmailFailedMail;
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

    public static function taxInvoices(): array
    {
        return ['invoice' => [OrderInvoiceMail::class], 'receipt' => [OrderPaidMail::class]];
    }

    /**
     * An Australian tax invoice must show the words "Tax Invoice", the
     * seller's name and ABN, the date issued, each item with its quantity and
     * price, and the GST included.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('taxInvoices')]
    public function test_tax_invoice_has_the_details_the_ato_requires($mailable)
    {
        // 2 November in Melbourne, still 1 November in UTC
        $this->travelTo('2026-11-01 14:00:00');
        $order = $this->order();

        (new $mailable($order))
            ->assertSeeInHtml('Tax Invoice')
            ->assertSeeInHtml('Toad Gully Growers')
            ->assertSeeInHtml('ABN:</strong> 61 173 928 602', false)
            ->assertSeeInHtml('Date issued:</strong> 2 November 2026', false)
            ->assertSeeInHtml('Order Date: </strong> 2 November 2026', false)
            ->assertSeeInOrderInHtml(['1', 'Farm Pack', '$110.00', '$110.00'])
            ->assertSeeInHtml('Includes GST: &nbsp;</strong> $10.00', false)
            ->assertSeeInHtml('Total: &nbsp;</strong> $110.00 AUD', false);
    }

    public function test_invoice_says_how_much_to_deposit()
    {
        (new OrderInvoiceMail($this->order()))
            ->assertSeeInHtml('please direct deposit <strong>$110.00</strong> to:', false);
    }

    public function test_invoice_pdf_includes_the_logos()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.orders.paid', ['orderDetails' => $this->order()])->output();

        $this->assertGreaterThanOrEqual(2, substr_count($pdf, '/Subtype /Image'));
    }

    public function test_receipt_says_how_the_order_was_paid()
    {
        $order = $this->order();

        $order->update(['payment_method' => PaymentMethod::Card]);
        (new OrderPaidMail($order->fresh()))
            ->assertSeeInHtml('Paid by credit card')
            ->assertSeeInHtml('Your order has been paid by credit card.');

        $order->update(['payment_method' => PaymentMethod::DirectDeposit]);
        (new OrderPaidMail($order->fresh()))
            ->assertSeeInHtml('Paid by direct deposit')
            ->assertSeeInHtml('We have received your direct deposit payment.')
            ->assertDontSeeInHtml('credit card');

        $order->update(['payment_method' => null]);
        (new OrderPaidMail($order->fresh()))
            ->assertSeeInHtml('Your order has been paid.')
            ->assertDontSeeInHtml('credit card')
            ->assertDontSeeInHtml('direct deposit');
    }

    public function test_email_shows_the_correct_gst_for_an_old_order_without_changing_it()
    {
        // Orders placed before October 2026 stored 1/10 of the total as GST
        $order = $this->order();
        $order->update(['total' => 100.00, 'gst' => 10.00]);

        (new OrderPaidMail($order))
            ->assertSeeInHtml('$9.09')
            ->assertDontSeeInHtml('$10.00');

        $this->assertEquals(10.00, $order->fresh()->gst);
    }

    public function test_invoice_email_lists_the_order_and_attaches_a_pdf()
    {
        $order = $this->order();
        $mail = new OrderInvoiceMail($order);

        $mail->assertSeeInHtml('Please include your order number (' . $order->id . ')');
        $mail->assertSeeInHtml('Farm Pack');
        $this->assertPdfAttached($mail);
    }

    public function test_email_failed_alert_tells_staff_who_to_contact()
    {
        $order = $this->order();
        $order->update(['phone' => '0491 570 006']);
        $mail = new OrderEmailFailedMail($order->fresh(), 'receipt', '550 mailbox unavailable');

        $mail->assertHasSubject('Order ' . $order->id . ' receipt email was not sent');
        $mail->assertSeeInText('could not be sent to John Doe (john@test.com)');
        $mail->assertSeeInText('Phone: 0491 570 006');
        $mail->assertSeeInText('Error: 550 mailbox unavailable');
    }

    public function test_payment_unconfirmed_email_tells_staff_which_order_to_check()
    {
        $order = $this->order();
        $mail = new PaymentUnconfirmedMail($order, '502 {"error":"gateway_error"}');

        $mail->assertHasSubject('Check card payment for order ' . $order->id);
        $mail->assertSeeInText('John Doe, john@test.com, $110.00');
        $mail->assertSeeInText('Pin response: 502 {"error":"gateway_error"}');
        $mail->assertSeeInText(route('backend.orders.edit', $order->id));
    }
}
