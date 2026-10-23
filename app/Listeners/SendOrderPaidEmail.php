<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Mail\OrderPaidMail;
use Illuminate\Support\Facades\Mail;

class SendOrderPaidEmail
{
    public function handle(OrderPaid $event): void
    {
        Mail::to($event->order)
            ->bcc(config('tgg.sales_email'))
            ->send(new OrderPaidMail($event->order));
    }
}
