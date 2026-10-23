<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $page = Page::where('slug', '=', 'cart')->firstOrFail();

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Cart::instance('cart')->add($request->id, $request->name, 1, $request->price);
        // ->associate('App\Models\Product');

        // redirect back to the cart page and display a success message
        return back()->with('success_message', 'Item was added to your cart.');




        //return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::instance('cart')->remove($id);
        return back()->with('success_message', "Item has been removed.");
    }
}
