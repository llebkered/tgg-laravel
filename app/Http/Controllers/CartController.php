<?php

namespace App\Http\Controllers;

use App\Actions\RefreshCart;
use App\Models\Order;
use App\Models\Page;
use App\Models\Variation;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RefreshCart $refreshCart)
    {
        $page = Page::where('slug', '=', 'cart')->firstOrFail();

        if ($changes = $refreshCart()) {
            session()->now('warning_message', $changes);
        }

        $cart = Cart::instance('cart')->content();

        $gst = number_format(Order::gstIncluded(Cart::instance('cart')->total(2, '.', '')), 2);

        // The variation for each cart item, looked up by id. find() returns
        // them sorted by id, not in cart order, so they can't be matched by
        // position.
        $variations = Variation::with('product')
            ->findMany($cart->pluck('id'))
            ->keyBy('id');

        return view('cart', compact('page'))->with(['variations' => $variations, 'gst' => $gst]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Only the variation id comes from the form. The name and price come
        // from the database, so they can't be changed in the browser.
        $variation = Variation::with('product')->find($request->input('id'));
        $product = $variation?->product;

        // Only items the product page offers can be added
        if (! $variation?->is_published || ! $product?->published || ! $product->stocked) {
            return back()->with('danger_message', 'Sorry, that item is not available.');
        }

        Cart::instance('cart')->add($variation->id, $product->title . ' - ' . $variation->title, 1, $variation->price);

        return back()->with('success_message', 'Item was added to your cart.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id  the cart row id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::instance('cart');

        // Already gone, from a double click, another tab or an expired session
        if ($cart->content()->has($id)) {
            $cart->remove($id);
        }

        return back()->with('success_message', "Item has been removed.");
    }
}
