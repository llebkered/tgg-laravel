<?php

namespace App\Http\Controllers\Checkout;

use App\Actions\RefreshCart;
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
    public function show(RefreshCart $refreshCart)
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        if ($changes = $refreshCart()) {
            session()->now('warning_message', $changes);
        }

        return view('checkout.index', ['page' => $page]);
    }

    public function store(CheckoutContactRequest $request, RefreshCart $refreshCart)
    {
        // The order is charged at the cart's prices, so the customer sees any
        // change in the cart before an order is made.
        if ($changes = $refreshCart()) {
            return redirect()->route('cart.index')->with('warning_message', $changes);
        }

        if (Cart::instance('cart')->count() === 0) {
            return redirect()->route('cart.index');
        }

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
