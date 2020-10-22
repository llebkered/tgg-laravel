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
        $hero = [
            'image' => '',
            'title' => 'Toad Gully Growers',
            'body' => '<p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia
            growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root
            Paulownia trees online, with postal delivery within Australia.</p>'
        ];

        $hero = Block::find(1);
        $blocks = Block::where('published',1)->where('hero', 0)->get();

        $page = Page::where('slug', '=', '/')->first();

        return view('home', compact('blocks','hero', 'page'));
    }
}
