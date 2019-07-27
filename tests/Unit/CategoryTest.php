<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_create()
    {
        $category = factory('App\Category')->raw();
        factory('App\Category')->create($category);

        $this->assertDatabaseHas('categories', $category);
    }

    /** @test */
    public function hasMany_feedEntities() {

        // Create Category
        $category = factory('App\Category')->create();

        // Create FeedEntity via relationship
        $feedEntity = $category->feedEntities()->create(
            factory('App\FeedEntity')->raw([
                    'category_id' => 1
                ])
        );

        // Checks if the given relationships exist
        // belongsTo:
        $this->assertTrue($feedEntity->category->id == $category->id);
        // HasMany:
        $this->assertTrue($category->feedEntities()->where(['category_id' => $category->id])->count() > 0);
    }
}
