<?php

namespace App\Mail;


use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->to($this->order->email, $this->order->name)
        ->from('sales@toadgully.com.au')
        ->bcc('sales@toadgully.com.au')
        ->subject('Order for Toad Gully Growers')
        ->markdown('emails.orders.paid');
    }
}
