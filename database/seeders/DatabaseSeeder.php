<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\TournamentSeeder;
use Database\Seeders\PlayerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $playerSeeder = new PlayerSeeder();
        $playerSeeder->run();

        $tournamentSeeder = new TournamentSeeder();
        $tournamentSeeder->run();
    }
}
