<?php

namespace App\Listeners;

use App\Mail\OrderEmailFailedMail;
use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait SendsOrderEmails
{
    /**
     * Email the customer, copying sales. If it fails, alert sales so someone
     * can follow up, rather than the customer silently getting nothing.
     *
     * @param  string  $description  which email this is, e.g. 'receipt'
     */
    protected function sendToCustomer(Order $order, Mailable $mail, string $description): void
    {
        try {
            Mail::to($order)
                ->bcc(config('tgg.sales_email'))
                ->send($mail);
        } catch (\Throwable $e) {
            report($e);

            // If the mail server is down this fails too, so it's only reported
            rescue(fn () => Mail::to(config('tgg.sales_email'))
                ->send(new OrderEmailFailedMail($order, $description, $e->getMessage())));
        }
    }
}
