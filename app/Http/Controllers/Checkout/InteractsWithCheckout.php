<?php

namespace App\Http\Controllers\Checkout;

use App\Models\Order;
use Illuminate\Http\Request;

trait InteractsWithCheckout
{
    protected const PAYMENT_IN_PROGRESS = 'A payment for this order is already being processed. Please do not pay again. Contact us if you have not received a confirmation email.';

    /**
     * The order being checked out, if any.
     */
    protected function currentOrder(Request $request): ?Order
    {
        return Order::find($request->session()->get('order'));
    }

    /**
     * True when the current order is paid, or the checkout has already
     * finished with a paid order.
     */
    protected function alreadyPaid(Request $request, ?Order $order): bool
    {
        if ($order) {
            return $order->isPaid();
        }

        return $request->session()->has('paid_order');
    }
}
