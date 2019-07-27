<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_auth_user_can_manage_news()
    {
        // Add categories
        $this->fillWithCategories();

        // Auth user
        $this->actingAs(factory('App\User')->create());
        $this->withoutExceptionHandling();

        // Can visit
        $this->get(route('news.index'))->assertStatus(200);
        $this->get(route('news.create'))->assertStatus(200);

        // Can create
        $attributes = [
            'title' => 'test',
            'content' => 'test',
            'category_id' => 1,
        ];

        $this->post(route('news.store'), $attributes)->assertRedirect(route('news.index'));

        unset($attributes['category_id']);
        $this->assertDatabaseHas('news_items', $attributes);
    }
}
