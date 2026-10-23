<?php

namespace App\Listeners;

use App\Events\OrderInvoiced;
use App\Mail\OrderInvoiceMail;

class SendOrderInvoiceEmail
{
    use SendsOrderEmails;

    public function handle(OrderInvoiced $event): void
    {
        $this->sendToCustomer($event->order, new OrderInvoiceMail($event->order), 'invoice');
    }
}
