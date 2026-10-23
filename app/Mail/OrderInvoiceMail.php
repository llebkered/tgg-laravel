<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Tax invoice for an order paid by direct deposit, with a PDF copy attached.
 */
class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $template = 'emails.orders.invoice';

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Toad Gully Growers Invoice');
    }

    public function content(): Content
    {
        return new Content(view: $this->template, with: ['orderDetails' => $this->order]);
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => Pdf::loadView($this->template, ['orderDetails' => $this->order])->output(),
                'invoice.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
