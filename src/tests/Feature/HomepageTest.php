<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_returns_200()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
