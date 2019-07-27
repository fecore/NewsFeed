<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedEntity extends Model
{

    protected  $guarded = [];
    //
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function feedEntitiable()
    {
        return $this->morphTo();
    }
}
