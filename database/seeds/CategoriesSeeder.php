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
                'appears_in_form' => 0
            ],
            [
                'title' => 'Итоги дня',
                'appears_in_form' => 0
            ]
        ];

        foreach ($categories as $category)
        {
            factory('App\Category')->create([
                'title' => $category['title'],
                'appears_in_form' => $category['appears_in_form'],
            ]);
        }
    }
}
