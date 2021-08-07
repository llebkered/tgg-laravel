<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackendProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('backend.product.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;

        return view('backend.product.create', compact('product'));
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
            'slug' => 'required|alpha_dash|unique:products,slug',
            'code' => 'alpha_dash',
            'description' => 'required',
        ]);

        $data['published'] = $request->published;
        $data['stocked'] = $request->stocked;

        $product = Product::create($data);

        return redirect()->route('backend.products.edit', $product->id)
            ->with('success_message', 'Product has been created successfully. You will need to add product variations for prices.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $images =  $product->getMedia('images');
        return view('backend.product.edit', compact('product','images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // $product->getFirstMedia('featured_image');
        // $product->getMedia('gallery');
      
        return view('backend.product.edit', compact('product'));
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
        $product = Product::find($id);

        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|alpha_dash',
            'code' => 'present',
            'description' => 'required'
        ]);

        $data['published'] = $request->published;
        $data['stocked'] = $request->stocked;
    
        if ($request->delete_image) {
            $product->clearMediaCollection('featured_image');
        }

        if ($request->file()) {
            $product->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
            return back()
                ->with('success', 'Featured image has been updated.');
        }
        
        $product->update($data);

        return redirect()->route('backend.products.edit', $id)->with('success_message', 'Product has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Product::clearMediaCollection('images');
        Product::destroy($id);
        return redirect()->route('backend.products.index')->with('success_message', 'Product has been deleted.');
    }
}
