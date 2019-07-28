<?php

namespace App\Http\Controllers\Admin;

use App\Events\ViewNews;
use App\FeedEntity;
use \App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // Get news that were manually created
        $feedEntitiesNewsItemsFiltered = FeedEntity::where('feed_entitiable_type', 'App\NewsItem')->orderBy('created_at', 'desc')->get();

        // Fire off event for generating weather
        event(new ViewNews());

        return view('admin.dashboard', compact('feedEntitiesNewsItemsFiltered'));

    }

}
