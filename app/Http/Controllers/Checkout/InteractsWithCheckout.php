<?php

namespace App\Http\Controllers\Checkout;

use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

trait InteractsWithCheckout
{
    protected const CART_CHANGED = 'Your cart has changed since you started checking out. Please check your order and enter your details again.';

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

    /**
     * True when the cart still holds exactly the items, quantities and prices
     * the order was made from. The order is charged at its own total, so if
     * the cart changed (e.g. in another tab) the customer would pay for
     * something other than what their cart shows.
     */
    protected function cartMatchesOrder(Order $order): bool
    {
        $items = fn ($rows) => collect($rows)
            ->mapWithKeys(fn ($row, $rowId) => [$rowId => [(string) ($row->id ?? ''), (int) ($row->qty ?? 0), (int) round(($row->price ?? 0) * 100)]])
            ->sortKeys()
            ->all();

        return $items(Cart::instance('cart')->content()) === $items($order->products);
    }
}
