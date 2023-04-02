<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Block;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hero = Block::where('published', 1)
            ->where('hero', 1)
            // ->orderByRaw('RAND()')
            ->inRandomOrder()
            ->first();

        $blocks = Block::where('published', 1)
            ->where('hero', 0)
            ->orderBy('weight', 'ASC')
            ->get();

        $page = Page::where('slug', '=', '/')->first();

        return view('home', compact('blocks', 'hero', 'page'));
    }
}
