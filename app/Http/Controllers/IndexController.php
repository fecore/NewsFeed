<?php

namespace App\Http\Controllers;

use App\Events\ViewNews;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Fire off event for generating weather
        event(new ViewNews());

        return view('layouts.master');
    }
}
