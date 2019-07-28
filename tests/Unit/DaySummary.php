<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DaySummary extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hasNewsItems()
    {
        // Create NewsItem with all related models
        $newsItem = factory('App\NewsItem')->create();

        // Testing relationship
        $this->assertTrue($newsItem->daySummary->id == $newsItem->day_summaries_id);

        // Testing in database
        $this->assertDatabaseHas('day_summaries', ['id' => $newsItem->day_summaries_id]);
        $this->assertDatabaseHas('news_items', ['day_summaries_id' => $newsItem->daySummary->id]);
    }
}
