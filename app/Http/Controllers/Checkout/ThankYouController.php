<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 * Shows the paid order. The receipt is emailed when the payment is made, so
 * refreshing this page is safe.
 */
class ThankYouController extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::find($request->session()->get('paid_order') ?? $request->session()->get('order'));

        if (is_null($order) || ! $order->isPaid()) {
            return redirect('/cart');
        }

        $page = Page::where('slug', '=', 'thankyou')->first();

        return view('checkout.thankyou', ['page' => $page, 'order' => $order]);
    }
}
