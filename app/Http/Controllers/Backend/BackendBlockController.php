<?php

namespace App\Http\Controllers\Backend;

use App\Models\Block;
use App\Models\Textcolour;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Backgroundcolour;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
        $block = new Block;
        return view('backend.block.create', compact(['background_colours', 'block','text_colours']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $block = $request->only(
            [
                'hero',
                'published',
                'weight',
                'text_colour',
                'background_colour',
                'background_image',
                'background_attachment',
                'heading',
                'heading_colour',
                'content',
                'content_background',
                'content_width',
                'content_position',
                'cta_title',
                'cta_link'
            ]
        );
        
        Block::create($block);

        return redirect('/backend/pages/1/edit')
            ->with('success_message', 'A new block has been created successfully.');
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
        $background_colours = Backgroundcolour::all();
        $text_colours = Textcolour::all();

        return view('backend.block.edit', compact(['background_colours', 'block','text_colours']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $block = Block::find($id);
        
        $background_colours = Backgroundcolour::all();
        $text_colours = Textcolour::all();

        $request->validate([
            'content' => 'required',
        ]);

        $data = $request->only(
            [
                'hero',
                'published',
                'weight',
                'text_colour',
                'background_colour',
                'background_image',
                'background_attachment',
                'heading',
                'heading_colour',
                'content',
                'content_background',
                'content_width',
                'content_position',
                'cta_title',
                'cta_link'
            ]
        );

        if ($request->input('deleteimage') == "on") {
            $data['background_image'] = null;
            $oldfile = $block->background_image;
            Storage::delete($oldfile);
        }

        if ($request->file('background_image')) {

            // validate the uploaded file
            $validation = $request->validate([
                'background_image' => 'required|file|image|mimes:jpeg,png,gif,webp|max:4096'
                // for multiple file uploads
                // 'photo.*' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
            ]);

            // remove old image
            $oldfile = $block->background_image;
            Storage::delete($oldfile);

            $file      = $validation['background_image'];
            $fileinfo = pathinfo($file->getClientOriginalName()); // no method for getting file name without extension?
            $extension = Str::lower($file->getClientOriginalExtension());
            $basename = Str::slug($fileinfo['filename']);
            $filename  = $basename . '.' . $extension;
            $path      = $file->storeAs('testing', $filename);

            // Resize & crop image
            $photo = Image::make($file)
                ->resize(1366, null, function ($constraint) {  // 1366 x 768
                    $constraint->aspectRatio();
                })
                ->resizeCanvas(1366, 768)
                ->encode('jpg', 80);
                
            // store filename and image object
            Storage::disk('public')->put('testing/' . $basename . '.jpg', $photo);
            // add new image path to page
            $block->background_image = $path;
        }

        $block->update($data);

        return redirect(url('backend/pages/1/edit'))->with('success_message', 'Block has been updated.');
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
