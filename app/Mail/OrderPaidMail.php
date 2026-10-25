<?php

namespace App\Mail;

/**
 * Tax invoice for a paid order (by card or direct deposit), with a PDF copy
 * attached.
 */
class OrderPaidMail extends OrderInvoiceMail
{
    protected string $template = 'emails.orders.paid';
}
