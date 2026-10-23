<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Tells the customer their order has been sent, with the tracking number and
 * an optional message from staff.
 */
class OrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('tgg.sales_email'), 'Toad Gully Growers'),
            subject: 'Order from Toad Gully Growers has been shipped',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.orders.shipped', with: ['orderDetails' => $this->order]);
    }
}
