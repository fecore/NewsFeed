<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\FeedEntity;
use Faker\Generator as Faker;

$factory->define(FeedEntity::class, function (Faker $faker) {


    $newsItem = factory('App\NewsItem')->create();

    return [
        'category_id' => factory('App\Category')->create(),
        'feed_entitiable_id' => $newsItem,
        'feed_entitiable_type' => 'App\NewsItem',
    ];
});
