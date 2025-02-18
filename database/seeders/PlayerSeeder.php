<?php

namespace Database\Seeders;

use App\Enums\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 8; $i++) { 
            Player::factory()->create([
                'genre' => Genre::Male->value,
                'name' => fake()->name(),
                'skill_level' => fake()->numberBetween(0, 100),
                'strong' => fake()->randomFloat(1, 3, 20),
                'speed' => fake()->randomFloat(1, 3, 20),
                'reaction_time' => null,
            ]);
            Player::factory()->create([
                'genre' => Genre::Female->value,
                'name' => fake()->name(),
                'skill_level' => fake()->numberBetween(0, 100),
                'reaction_time' => fake()->randomFloat(1, 3, 20),
                'strong' => null,
                'speed' => null,
            ]);
        }
    }
}
