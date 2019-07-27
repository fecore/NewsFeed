<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */

    public function indexPage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
