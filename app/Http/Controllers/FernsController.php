<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Plant;
use Illuminate\Http\Request;

class FernsController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '=', 'ferns')->firstOrFail();

        $ferns = Plant::where('plantcategory_id', '=', '1')->where('published', '=', '1')->orderBy('botanical_name', 'ASC')->paginate(24);

        return view('ferns', compact(['page']))->with('ferns', $ferns);
    }
}
