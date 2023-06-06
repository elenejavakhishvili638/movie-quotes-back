<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create('ka_GE');
        return [
            'movie_id' => Movie::factory(),
            'body' => [
                'en' => $faker->sentence(),
                'ka' => $faker->realText(10),
            ],
            'image' => $this->faker->imageUrl(),
        ];
    }
}
