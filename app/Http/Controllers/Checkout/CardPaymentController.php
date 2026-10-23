<?php

namespace App\Http\Controllers\Checkout;

use App\Actions\ChargeOrder;
use App\Enums\ChargeStatus;
use App\Events\OrderPaid;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutCardRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Page;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

/**
 * Checkout step 3: pay by card. The page also links to direct deposit.
 */
class CardPaymentController extends Controller
{
    use InteractsWithCheckout;

    private const PAYMENT_UNCONFIRMED = 'We could not confirm your payment. Your card may have been charged, so please do not try again. We will check your payment and contact you by email.';

    public function show(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        // Already paid (e.g. back button after paying)
        if ($this->alreadyPaid($request, $this->currentOrder($request))) {
            return redirect()->route('checkout.thankyou');
        }

        $customer = Customer::find($request->session()->get('customer'));
        $year = date('Y');

        return view('checkout.card', compact('page', 'year', 'customer'));
    }

    public function store(CheckoutCardRequest $request, ChargeOrder $chargeOrder)
    {
        $order = $this->currentOrder($request);

        // Already paid (e.g. back button or a resubmitted form)
        if ($this->alreadyPaid($request, $order)) {
            return redirect()->route('checkout.thankyou');
        }

        if (is_null($order)) {
            return redirect('/cart');
        }

        $result = $chargeOrder($order, $request->card());

        if ($result->status === ChargeStatus::Paid) {
            $this->completePaidOrder($request, $order);

            return redirect()->route('checkout.thankyou')->with('success_message', 'Your payment has been successful.');
        }

        $message = match ($result->status) {
            ChargeStatus::Declined => $result->message,
            ChargeStatus::AlreadyClaimed => self::PAYMENT_IN_PROGRESS,
            ChargeStatus::Unconfirmed => self::PAYMENT_UNCONFIRMED,
        };

        return redirect()->route('checkout.card')->with('danger_message', $message)->withInput($request->except(['number', 'cvc']));
    }

    /**
     * Empty the cart, end the checkout and send the receipt. The paid order
     * stays in the session so the thank-you page can show it, even on refresh.
     */
    private function completePaidOrder(Request $request, Order $order)
    {
        Cart::instance('cart')->destroy();

        $request->session()->forget(['customer', 'order']);
        $request->session()->put('paid_order', $order->id);

        // The card has been charged, so a failed email must not stop the
        // checkout finishing. rescue() reports the error instead.
        rescue(fn () => OrderPaid::dispatch($order));
    }
}
