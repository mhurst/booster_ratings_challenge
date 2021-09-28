<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\Rating;

class GeneralTest extends TestCase
{
    /**
     * Home Page test
     *
     * @return void
     */
    public function test_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Reviews Page test
     *
     * @return void
     */
    public function test_reviews_page()
    {
        //Given we have tanks in the database
        $rating = Rating::factory()->create();

        $response = $this->get('/fundraisers-review-form/' . $rating->id);

        $response->assertStatus(200);
    }
}
