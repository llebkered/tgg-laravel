<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Mail\OrderPaidMail;

class SendOrderPaidEmail
{
    use SendsOrderEmails;

    public function handle(OrderPaid $event): void
    {
        $this->sendToCustomer($event->order, new OrderPaidMail($event->order), 'receipt');
    }
}
