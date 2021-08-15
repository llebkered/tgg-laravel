<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class pageGalleryController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $page = Page::where('id', '=', $id)->first();

        return view('backend.pagegallery.create')->with(['page' => $page]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = Page::where('id', '=', $request->id)->first();
        
        if ($request->file()) {
            $page->addMediaFromRequest('gallery')->toMediaCollection('gallery');
            return back()
                ->with('success', 'Gallery image has been added.');
        }
        
    }

 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pageId, $mediaId)
    {
        $page = page::where('id', '=', $pageId)->first();
        $page->deleteMedia($mediaId);

        return redirect()->route('backend.pages.edit', $pageId)->with('success_message', 'Gallery item has been deleted.');
    }
}
