<?php

namespace App\Listeners;

use App\Events\OrderInvoiced;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;

class SendOrderInvoiceEmail
{
    public function handle(OrderInvoiced $event): void
    {
        Mail::to($event->order)
            ->bcc(config('tgg.sales_email'))
            ->send(new OrderInvoiceMail($event->order));
    }
}
