<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Tells staff a customer's order email couldn't be sent, so they can follow up.
 */
class OrderEmailFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string  $email  which email failed, e.g. 'receipt'
     */
    public function __construct(public Order $order, public string $email, public string $error)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Order ' . $this->order->id . ' ' . $this->email . ' email was not sent');
    }

    public function content(): Content
    {
        return new Content(text: 'emails.orders.email-failed');
    }
}
