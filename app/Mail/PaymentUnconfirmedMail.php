<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Tells staff a card payment's outcome is unknown, so they can check it in Pin.
 */
class PaymentUnconfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order, public string $detail)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Check card payment for order ' . $this->order->id);
    }

    public function content(): Content
    {
        return new Content(text: 'emails.orders.payment-unconfirmed');
    }
}
