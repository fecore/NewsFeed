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

        $this->withoutExceptionHandling();

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

        $this->post(route('news.store'), $attributes)->assertRedirect(route('dashboard'));

        unset($attributes['category_id']);
        $this->assertDatabaseHas('news_items', $attributes);
    }

    /** @test */
    public function only_auth_user_can_update_news()
    {
        // Auth user
        $this->actingAs(factory('App\User')->create());
        $this->withoutExceptionHandling();
        // Insert categories
        $this->fillWithCategories();

        // Create new FeedEntity
        // with NewsItem and Category related
        $feedEntity = factory('App\FeedEntity')->create();

        $sendAttributes = [
            'category_id' => 2,
            'title' => 'new_title',
            'content' => 'new_content'
        ];

        // Update request
        $this->put(route('news.update', $feedEntity->feedEntitiable), $sendAttributes)->assertStatus(302);

        $newsItemsAttributesSearch = $sendAttributes;
        $feedEntityAttributesSearch['category_id'] = $newsItemsAttributesSearch['category_id'];
        unset($newsItemsAttributesSearch['category_id']);

        // Asserting that information has been successfully updated in database
        // in news_items table:
        $this->assertDatabaseHas('news_items', $newsItemsAttributesSearch);
        // and in feed_entities table:
        $this->assertDatabaseHas('feed_entities', $feedEntityAttributesSearch);
    }

    /** @test */
    public function only_auth_user_can_edit_news () {
        // Insert categories
        $this->fillWithCategories();

        // Auth user
        $this->actingAs(factory('App\User')->create());
//        $this->withoutExceptionHandling();

        // Create new FeedEntity
        // with NewsItem and Category related
        $feedEntity = factory('App\FeedEntity')->create();

        $this->get(route('news.edit', $feedEntity->feedEntitiable))->assertStatus(200);
    }
    
    /** @test */
    public function only_auth_user_can_view_news()
    {
        // Insert categories
        $this->fillWithCategories();

        // Auth user
        $this->actingAs(factory('App\User')->create());
//        $this->withoutExceptionHandling();

        // Create new FeedEntity
        // with NewsItem and Category related
        $feedEntity = factory('App\FeedEntity')->create();

        $this->get(route('news.show', $feedEntity->feedEntitiable))
            ->assertStatus(200)
            ->assertSee($feedEntity->feedEntitiable->title);
    }
}
