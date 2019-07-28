<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaySummary extends Model
{
    //
    protected $guarded = [];

    public function feedEntity()
    {
        return $this->morphOne(FeedEntity::class, 'feed_entitiable');
    }

    public function newsItems()
    {
        return $this->hasMany('App\NewsItem', 'day_summaries_id');
    }
}
