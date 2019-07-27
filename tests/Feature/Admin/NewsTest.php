<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function only_auth_user_can_manage_news()
    {
        $this->actingAs(factory('App\User')->create());

        $this->get(route('news.index'))->assertStatus(200);
        $this->get(route('news.create'))->assertStatus(200);
    }

    /** @test */
    public function guests_cannot_manage_news()
    {
        $this->get(route('news.index'))->assertRedirect(route('login'));
        $this->get(route('news.create'))->assertRedirect(route('login'));
    }
}
