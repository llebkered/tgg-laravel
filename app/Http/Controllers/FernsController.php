<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Plant;
use Illuminate\Http\Request;

class FernsController extends Controller
{
    public function index(){
        $page = Page::where('slug', '=', 'ferns')->first();

        $ferns = Plant::where('plantcategory_id', '=', '1')->paginate(24);

        return view('ferns', compact(['page']))->with('ferns', $ferns);
    }
}
