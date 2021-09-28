<?php

namespace Database\Factories;

use App\Models\Fundraiser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FundraisersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fundraiser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Test Fundraiser'
        ];
    }
}
