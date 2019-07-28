<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\ViewNews;
use App\FeedEntity;
use Carbon\Carbon;
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

        // Loads all categories
        // Also categories that are reserved for application

        $allCategories = Category::all();

        // Loads all feedEntities for the last 15 days
        $feedEntities = FeedEntity::whereDate('created_at', '>=', Carbon::now()->subDays(15))->get();


        return view('index', compact('allCategories', 'feedEntities'));
    }
}
