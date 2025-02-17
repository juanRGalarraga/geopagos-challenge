<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Player;
use App\Enums\Genre;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;

class PlayTournament extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:play-tournament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $players = Player::factory()->count(8)->create([
            'genre' => Genre::Male->value
        ]);

        $tournament = new Tournament($players);

        $tournament->create(Genre::Male->value, $players->toArray());

        $this->info('Tournament winner: ' . $tournament->winner->name);
    }
}
