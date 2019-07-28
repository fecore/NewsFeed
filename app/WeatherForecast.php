<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{

    protected $guarded= [];
    //
    public function feedEntity()
    {
        return $this->morphOne(FeedEntity::class, 'feed_entitiable');
    }
}
