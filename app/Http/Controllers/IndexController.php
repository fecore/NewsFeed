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
        $feedEntities = FeedEntity::whereDate('created_at', '>=', Carbon::now()
                    ->subDays(15))
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('index', compact('allCategories', 'feedEntities'));
    }

    public function category(Category $category)
    {

        // Fire off event for generating weather
        event(new ViewNews());

        // Loads all categories
        // Also categories that are reserved for application
        $allCategories = Category::all();

        // Loads all feedEntities for the last 15 days
        $feedEntities = FeedEntity::whereDate('created_at', '>=', Carbon::now()
                ->subDays(15))
                ->orderBy('created_at', 'desc')
                ->where('category_id', $category->id)
                ->get();

        return view('category', compact('allCategories', 'feedEntities'));
    }

    public function show(FeedEntity $feedEntity)
    {

        // Loads all categories
        // Also categories that are reserved for application
        $allCategories = Category::all();
        // Replace "open"-link with "go back"-link
        $article = true;
        return view('article', compact('allCategories', 'feedEntity', 'article'));

    }
}
