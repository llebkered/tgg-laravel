<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackendVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $variation = new Variation;

        return view('backend.variation.create', compact('product', 'variation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'product_id' => 'numeric'
        ]);

        Variation::create($data);

        return redirect()->route('backend.products.edit', $data['product_id']);

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
    public function edit(Variation $variation)
    {
        return view('backend.variation.edit', compact('variation'));
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
        $variation = Variation::find($id);

        $data = $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        $variation->update($data);

        return redirect()->route('backend.products.show', $variation->product->id)->with('success_message', 'Product varation has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variation = Variation::find($id);
        Variation::destroy($id);
        return redirect()->route('backend.products.show', $variation->product->id)->with('success_message', 'Product variation has been deleted.');
    }
}
