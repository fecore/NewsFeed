<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            [
                'title' => 'Наука',
                'appears_in_form' => true
            ],
            [
                'title' => 'Спорт',
                'appears_in_form' => true
            ],
            [
                'title' => 'Город',
                'appears_in_form' => true
            ],
            [
                'title' => 'Мода',
                'appears_in_form' => true
            ],
            [
                'title' => 'Погода',
                'appears_in_form' => 0,
                'type' => 'weather_forecast',
            ],
            [
                'title' => 'Итоги дня',
                'appears_in_form' => 0,
                'type' => 'day_summary',
            ]
        ];

        foreach ($categories as $category)
        {
            factory('App\Category')->create($category);
        }
    }
}
