<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutContactRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Page;
use Gloudemans\Shoppingcart\Facades\Cart;

/**
 * Checkout step 1: the customer's contact details. Creates the order.
 */
class ContactController extends Controller
{
    public function show()
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        return view('checkout.index', ['page' => $page]);
    }

    public function store(CheckoutContactRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::create($data);

        $cart = Cart::instance('cart');

        // Unformatted amounts, so totals of $1,000 or more save correctly
        $total = $cart->total(2, '.', '');

        $order = Order::create([
            'customer_id' => $customer->id,
            'order_status_id' => OrderStatus::InCart,
            'cart' => json_encode($cart->content()),
            'tax' => $cart->tax(2, '.', ''),
            'gst' => Order::gstIncluded($total),
            'total' => $total,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $request->session()->put(['customer' => $customer->id, 'order' => $order->id]);

        return redirect()->route('checkout.delivery');
    }
}
