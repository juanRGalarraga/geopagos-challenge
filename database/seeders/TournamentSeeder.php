<?php

namespace Database\Seeders;

use App\Enums\Genre;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 8; $i++) { 
            Tournament::factory()->create([
                'type' => Genre::Male->value,
            ]);
        }

        for ($i=8; $i < 16; $i++) { 
            Tournament::factory()->create([
                'type' => Genre::Female->value,
            ]);
        }
    }
}
