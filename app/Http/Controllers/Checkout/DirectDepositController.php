<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Events\OrderInvoiced;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

/**
 * Checkout alternative to step 3: place the order to pay by direct deposit.
 */
class DirectDepositController extends Controller
{
    use InteractsWithCheckout;

    public function __invoke(Request $request)
    {
        $order = $this->currentOrder($request);

        // Already paid by card (e.g. back button after paying)
        if ($this->alreadyPaid($request, $order)) {
            return redirect()->route('checkout.thankyou');
        }

        if (is_null($order)) {
            return redirect('/cart');
        }

        // A card payment has been started, so the card may have been charged
        if ($order->payment_started_at) {
            return redirect()->route('checkout.card')->with('danger_message', self::PAYMENT_IN_PROGRESS);
        }

        $order->order_status_id = OrderStatus::Invoiced;
        $order->payment_method = PaymentMethod::DirectDeposit;
        $order->save();

        Cart::instance('cart')->destroy();
        $request->session()->forget(['customer', 'order']);

        // The order is placed and this page shows how to pay, so a failed
        // email must not stop it showing. The listener alerts sales if the
        // email fails, and rescue() reports anything else.
        rescue(fn () => OrderInvoiced::dispatch($order));

        $page = Page::where('slug', '=', 'checkout')->first();

        return view('checkout.directdeposit', ['page' => $page, 'order' => $order]);
    }
}
