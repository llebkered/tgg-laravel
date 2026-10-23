<?php

namespace App\Listeners;

use App\Mail\OrderEmailFailedMail;
use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * For queued listeners that email the customer. A failed send is retried, and
 * sales are alerted once every attempt has failed. With the sync queue there
 * are no retries, so sales are alerted straight away.
 */
trait SendsOrderEmails
{
    public $tries = 3;

    // Seconds between attempts
    public $backoff = 60;

    /**
     * Email the customer, copying sales. Throws on failure so the queue can
     * retry.
     */
    protected function sendToCustomer(Order $order, Mailable $mail): void
    {
        Mail::to($order)
            ->bcc(config('tgg.sales_email'))
            ->send($mail);
    }

    /**
     * Tell sales the customer's email wasn't sent, so someone can follow up.
     *
     * @param  string  $description  which email failed, e.g. 'receipt'
     */
    protected function alertSales(Order $order, string $description, Throwable $e): void
    {
        // If the mail server is down this fails too, so it's only reported
        rescue(fn () => Mail::to(config('tgg.sales_email'))
            ->send(new OrderEmailFailedMail($order, $description, $e->getMessage())));
    }
}
