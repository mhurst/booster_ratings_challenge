<?php

namespace Database\Factories;

use App\Models\Reviewer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reviewer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Tom Test',
            'email' => 'tom@gmail.com,'
            'email_verified' => true
        ];
    }
}
