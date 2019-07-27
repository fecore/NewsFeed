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
        $attributes = $request->validated();

        // Unset category_id for newsItem
        $category_id = $attributes['category_id'];
        unset($attributes['category_id']);

        try{
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
            // Writing into logs
            Log::error('news.store: DB transaction failed: ' . $e->getMessage());
            return redirect(route('news.create'))->withErrors('db_error', 'Something went wrong, try again later!');
        }

        return redirect(route('news.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreNews $request, $id)
    {
        // Validate
        $attributes = $request->validated();


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
