<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Genre;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genre = $this->faker->randomElement([Genre::Male->value, Genre::Female->value]);
        $attributes = [
            'name' => $this->faker->name,
            'genre' => $genre,
            'skill_level' => $this->faker->numberBetween(0, 100),
        ];

        if($genre == Genre::Male->value){
            $attributes['speed'] = $this->faker->randomFloat(1, 0, 10);
            $attributes['strong'] = $this->faker->randomFloat(1, 0, 10);
        } else {
            $attributes['reaction_time'] = $this->faker->randomFloat(1, 0, 10);
        }

        return $attributes;
    }
}
