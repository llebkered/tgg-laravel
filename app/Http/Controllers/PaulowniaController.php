<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PaulowniaController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '=', 'paulownia')->firstOrFail();

        return view('paulownia', compact('page'));
    }
}
