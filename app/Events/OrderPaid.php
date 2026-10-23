<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * An order has been paid by card.
 */
class OrderPaid
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order)
    {
    }
}
