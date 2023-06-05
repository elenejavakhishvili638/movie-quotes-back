<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
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
            'user_id' => User::factory(),
            'title' => [
                'en' => $faker->sentence(),
                'ka' => $faker->realText(10),
            ],
            'year' => $this->faker->numberBetween($min = 1900, $max = 2023),
            'genre' => $this->faker->word(),
            'director' => [
                'en' => $faker->name(),
                'ka' => $faker->realText(10)
            ],
            'description' => [
                'en' => $faker->sentence(),
                'ka' => $faker->sentence(10)
            ],
            'image' => $this->faker->imageUrl(),
        ];
    }
}
