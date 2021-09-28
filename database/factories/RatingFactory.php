<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fundraisers_id' => 1,
            'reviewer_id' => 1,
            'rating' => 5,
            'review' => $this->faker->text,
            'review_date' => \Carbon\Carbon::now()
        ];
    }
}
