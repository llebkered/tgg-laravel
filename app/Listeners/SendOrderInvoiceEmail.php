<?php

namespace App\Listeners;

use App\Events\OrderInvoiced;
use App\Mail\OrderInvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class SendOrderInvoiceEmail implements ShouldQueue
{
    use SendsOrderEmails;

    public function handle(OrderInvoiced $event): void
    {
        $this->sendToCustomer($event->order, new OrderInvoiceMail($event->order));
    }

    /**
     * Every attempt to send the invoice has failed.
     */
    public function failed(OrderInvoiced $event, Throwable $e): void
    {
        $this->alertSales($event->order, 'invoice', $e);
    }
}
