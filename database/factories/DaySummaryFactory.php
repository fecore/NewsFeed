<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\DaySummary;
use Faker\Generator as Faker;

$factory->define(DaySummary::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(1),
    ];
});
