<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutDeliveryRequest;
use App\Models\Page;

/**
 * Checkout step 2: the delivery address.
 */
class DeliveryController extends Controller
{
    use InteractsWithCheckout;

    public function show()
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        return view('checkout.delivery', ['page' => $page]);
    }

    public function store(CheckoutDeliveryRequest $request)
    {
        $order = $this->currentOrder($request);

        if (is_null($order)) {
            return redirect('/cart');
        }

        $order->update($request->only('line1', 'line2', 'postcode', 'city', 'state', 'country'));

        return redirect()->route('checkout.card');
    }
}
