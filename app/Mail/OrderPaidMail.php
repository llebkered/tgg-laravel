<?php

namespace App\Mail;

/**
 * Tax invoice for an order paid by card, with a PDF copy attached.
 */
class OrderPaidMail extends OrderInvoiceMail
{
    protected string $template = 'emails.orders.paid';
}
