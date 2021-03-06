<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected  $guarded = [];
    //

    public function feedEntity()
    {
        return $this->morphOne(FeedEntity::class, 'feed_entitiable');
    }

    public function daySummary()
    {
        return $this->belongsTo('App\DaySummary', 'day_summaries_id');
    }
}
