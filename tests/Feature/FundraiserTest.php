<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FundraiserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_read_all_the_fundraisers()
    {
        //When user visit the fundraisers page
        $response = $this->get('/api/fundraisers');
        
        // dd($response);

        //User should be able to read the fundraisers
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'fundraiser_name' => 'Bonfire'
            ]);
    }
}
