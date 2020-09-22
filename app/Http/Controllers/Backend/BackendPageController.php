<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BackendPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();

        return view('backend.page.index', compact(['pages']));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('backend.page.edit', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {


        return view('backend.page.edit', compact('page'));
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
        //https://scotch.io/tutorials/understanding-and-working-with-files-in-laravel

        $page = Page::find($id);

        if ($request->file('image')) {

            // validate the uploaded file
            $validation = $request->validate([
                'image' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
                // for multiple file uploads
                // 'photo.*' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
            ]);

            // remove old image
            $oldfile = $page->image;
            Storage::delete($oldfile);
            // add new image
            $file      = $validation['image']; // get the validated file

            // how to resize
            // https://codebriefly.com/laravel-image-processing-intervention-image-package/
            // http://www.expertphp.in/article/php-laravel-5-intervention-image-upload-and-resize-tutorial
            // dd($file->getClientOriginalName());
            // $extension = $file->getClientOriginalExtension();
            // $filename  = 'profile-photo-' . time() . '.' . $extension;
            // $path      = $file->storeAs('testing', $filename);
            $path = $request->file('image')->store('testing');
            // Image::make(storage_path($filename))->resize(300, 200);
            $page->image = $path;
        }

        $page->update();

        return redirect()->back()->with('success_message', 'Page has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
