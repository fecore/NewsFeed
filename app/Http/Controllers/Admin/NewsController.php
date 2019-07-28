<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Events\DaySummaryEvent;
use App\FeedEntity;
use \App\Http\Controllers\Controller;

use App\Http\Requests\StoreNews;
use App\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class NewsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get categories
        // Only that can be used

        $categories = Category::where([['appears_in_form', 1]])->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(StoreNews $request)
    {
        // Validate
        // Validating from FormRequest class "StoreNews"
        $attributes = $request->validated();

        // Unset category_id for NewsItem model
        $category_id = $attributes['category_id'];
        unset($attributes['category_id']);

        try{
            // Start transaction
            DB::transaction(function() use ($attributes, $category_id, $request)
            {
                // If main_category was checked
                $attributes['main_news'] = ($request->has('main_news')) ? 1 : 0;

                $newsItem = NewsItem::create($attributes);
                $feedEntity = FeedEntity::create(
                [
                    'category_id' => $category_id,
                    'feed_entitiable_id' => $newsItem->id,
                    'feed_entitiable_type' => NewsItem::class,
                ]);

                // Trigger Event
                // To generate DaySummary
                // For today
                event(new DaySummaryEvent($newsItem, 'storing'));
            });
        }
        catch (\Exception $e)
        {
            // If transaction fails
            // Then write it to a log file
            // And redirect back with a session error
            // Only in production mode

            if (App::environment('production')) {
                return $this->LogTransactionFailed(route('news.create'), $e);
            }
            else
            {
                // Otherwise throw error
                throw $e;
            }
        }

        return redirect(route('dashboard'));
    }

    public function show(NewsItem $newsItem)
    {
        return view('admin.news.show', compact('newsItem'));
    }

    public function edit(NewsItem $newsItem)
    {
        // First get categories for option list in form
        $categories = Category::where('appears_in_form', 1)->get();

        return view('admin.news.edit', compact('categories', 'newsItem'));
    }

    public function update(StoreNews $request, NewsItem $newsItem)
    {
        // Validate
        // Validating from FormRequest class "StoreNews"
        $attributes = $request->validated();

        // Unset category_id for NewsItem model
        $category_id = $attributes['category_id'];
        unset($attributes['category_id']);

        try{
            // Start transaction
            DB::transaction(function() use ($attributes, $category_id, $newsItem, $request)
            {
                // If main_category was checked
                $attributes['main_news'] = ($request->has('main_news')) ? 1 : 0;


                // Updating NewsItem model
                $newsItem->update($attributes);

                // Then update FeedEntity
                $newsItem->feedEntity->update(['category_id' => $category_id]);

                // Trigger Event
                // To update DaySummary
                // For today
                event(new DaySummaryEvent($newsItem, 'updating'));
            });
        }
        catch (\Exception $e)
        {
            // If transaction fails
            // Then write it to a log file
            // And redirect back with a session error
            // Only in production mode

            if (App::environment('production')) {
                return $this->LogTransactionFailed(route('news.update', $newsItem), $e);
            }
            else
            {
                // Otherwise throw error
                throw $e;
            }
        }

        return redirect (route('news.show', $newsItem));
    }

    public function destroy(NewsItem $newsItem)
    {
        DB::transaction(function() use ($newsItem) {
            $newsItem->feedEntity()->delete();
            $newsItem->delete();
        });

        return redirect(route('dashboard'));
    }

    public function LogTransactionFailed($route, $e)
    {
        // Writing into logs

        Log::error($route . ': DB transaction failed: ' . $e->getMessage());
        return redirect($route)->withErrors('db_error', 'Something went wrong, try again later!');
    }

}
