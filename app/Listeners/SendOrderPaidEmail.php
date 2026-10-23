<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Mail\OrderPaidMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class SendOrderPaidEmail implements ShouldQueue
{
    use SendsOrderEmails;

    public function handle(OrderPaid $event): void
    {
        $this->sendToCustomer($event->order, new OrderPaidMail($event->order));
    }

    /**
     * Every attempt to send the receipt has failed.
     */
    public function failed(OrderPaid $event, Throwable $e): void
    {
        $this->alertSales($event->order, 'receipt', $e);
    }
}
