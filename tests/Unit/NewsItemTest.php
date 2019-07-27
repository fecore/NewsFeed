<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create()
    {
        $newsItem = factory('App\NewsItem')->raw();
        factory('App\NewsItem')->create($newsItem);

        $this->assertDatabaseHas('news_items', $newsItem);
    }
    
//    /** @test */
//    public function HasFeedEntity()
//    {
//        // Add categories
//        Artisan::call('db:seed', ['--class' => 'CategoriesSeeder']);
//
//        $newsItemRaw = factory('App\NewsItem')->raw();
//        $newsItem = factory('App\NewsItem')->create($newsItemRaw);
//
//        // Create
//        $feedEntity = $newsItem->feedEntity()->create(['category_id' => 1]);
//
//
//    }
}
