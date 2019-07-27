<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\NewsItem;
use Faker\Generator as Faker;

$factory->define(NewsItem::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(1),
        'content' => $faker->text(500),
    ];
});
