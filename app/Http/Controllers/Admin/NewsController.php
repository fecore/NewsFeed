<?php

namespace App\Http\Controllers\Admin;

use App\FeedEntity;
use \App\Http\Controllers\Controller;

use App\Http\Requests\StoreNews;
use App\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        //
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
            DB::transaction(function() use ($attributes, $category_id)
            {
                $newsItem = NewsItem::create($attributes);

                $feedEntity = FeedEntity::create(
                [
                    'category_id' => $category_id,
                    'feed_entitiable_id' => $newsItem->id,
                    'feed_entitiable_type' => NewsItem::class,
                ]);
            });
        }
        catch (\Exception $e)
        {
            // If transaction fails
            // Then write it to a log file
            // And redirect back with a session error
            return $this->LogTransactionFailed(route('news.create'), $e);
        }

        return redirect(route('news.index'));
    }

    public function show(NewsItem $newsItem)
    {
        $title = $newsItem->title;
        $content = $newsItem->content;

        return view('admin.news.show', compact('title', 'content'));
    }

    public function edit(Request $request, $id)
    {

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
            DB::transaction(function() use ($attributes, $category_id, $newsItem)
            {
                // Updating NewsItem model
                $newsItem->update($attributes);

                // Then update FeedEntity
                $newsItem->feedEntity->update(['category_id' => $category_id]);
            });
        }
        catch (\Exception $e)
        {
            // If transaction fails
            // Then write it to a log file
            // And redirect back with a session error
            return $this->LogTransactionFailed(route('news.update'), $e);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function LogTransactionFailed($route, $e)
    {
        // Writing into logs
        Log::error($route . ': DB transaction failed: ' . $e->getMessage());
        return redirect($route)->withErrors('db_error', 'Something went wrong, try again later!');
    }

}
