<?php

namespace App\Listeners;

use App\Category;
use App\Events\ViewNews;
use App\FeedEntity;
use App\WeatherForecast;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;

class GenerateWeather
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(ViewNews $event)
    {

        $now = time();

        $dayNow = strtotime(date("Y-m-d", $now));

        $dateTimeForWeatherToday = $dayNow + 9 * 60 * 60;

        if(WeatherForecast::all()->count() > 0) {

            // If there is one

            // Select the last one
            $latestWeatherForecast = FeedEntity::where('feed_entitiable_type', 'App\WeatherForecast')->latest()->first()->feedEntitiable;

            $feedEntityCreatedDateTime = $latestWeatherForecast->feedEntity->created_at;

            // Get date
            // and convert to days
            $dayCreatedLastEntity = date("Y-m-d", strtotime($feedEntityCreatedDateTime));

            // Then convert to unix
            $unixdayCreatedLastEntity = strtotime($dayCreatedLastEntity);

            // Then substract
            // And convert to days
            $daysSubstracted = ($dayNow - $unixdayCreatedLastEntity) / 60 / 60 / 24;

            for ($i = 1; $i <= $daysSubstracted; $i++) {

                $unixDateTime = ($unixdayCreatedLastEntity + (60*60*24)* $i + (60*60*9));

                // Convert to sql datetime format
                $timeStampSql = date('Y-m-d H:i:s', $unixDateTime);

                // Write to database

                $this->insertWeatherForecast($timeStampSql);
            }
        }
        else
        {
            $this->insertWeatherForecast($dateTimeForWeatherToday);
        }
    }

    public function insertWeatherForecast($dateTimeForWeatherToday)
    {
        // Start transaction
        DB::transaction(function() use ($dateTimeForWeatherToday)
        {

            $categoryModel = new Category;
            $weatherForecastModel = new WeatherForecast;

            // And related FeedEntity
            // But first load category id needed for weatherforecast
            $category = $categoryModel->where('type', 'weather_forecast')->first();

            // If category not found throw exception
            if (!$category) {
                throw new ErrorException('NO CATEGORIES FOUND!!, create category with ´type´ = \'weather_forecast\'');
            }

            // So let's create for today
            // Store weather forecast
            $weatherForecast = $weatherForecastModel->create([
                'title' => 'Прогноз погоды',
                'content' => "Утро: +15, День: +12, вечер: +5 ветер: 2м/с.",

                // So you can sort it easily
                'created_at' => $dateTimeForWeatherToday,
            ]);


            // Creating feedEntity
            // With created_at at 9:00
            $weatherForecast->feedEntity()->create([
                'category_id' => $category->id,

                // So you can sort it easily
                'created_at' => $dateTimeForWeatherToday,
            ]);

        });
    }
}
