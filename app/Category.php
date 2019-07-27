<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $guarded = [];
    //
    public function feedEntities()
    {
        return $this->hasMany('App\FeedEntity');
    }
}
