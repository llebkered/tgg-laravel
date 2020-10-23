<?php

namespace App\Http\Controllers\Backend;

use App\Models\Block;
use App\Models\Textcolour;
use Illuminate\Http\Request;
use App\Models\Backgroundcolour;
use App\Http\Controllers\Controller;

class BackendBlockController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $background_colours = Backgroundcolour::all();
        $text_colours = Textcolour::all();
        return view('backend.block.create', compact(['background_colours','text_colours']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'slug' => 'required|alpha_dash|unique:pages,slug'
        //     // 'excerpt' => '',
        //     // 'body' => '',
        //     // 'image' => '',
        //     // 'meta_description' => '',
        //     // 'meta_keywords' => '',
        //     // 'status' => ''
        // ]);


        // $block = $request->only(
        //     [
        //         'title',
        //         'slug',
        //         'excerpt',
        //         'body',
        //         'image',
        //         'meta_description',
        //         'meta_keywords',
        //         'status'
        //     ]
        // );

        // $block['author_id'] = Auth::id();

        // Block::create($block);

        dd($request->all());

        return redirect()->route('backend.pages')
            ->with('success', 'Block has been created successfully.');
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        return view('backend.block.edit', compact('block'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        //
    }
}
