<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Player;
use App\Enums\Genre;
use App\Models\Game;
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
        $players = [
            Player::find(17),
            Player::find(18),
            Player::find(19),
            Player::find(20),
            Player::find(21),
            Player::find(22),
            Player::find(23),
            Player::find(24)
        ];
        
        $tournament = new Tournament();
        $maleTournament = $tournament::create([
            'name' => 'Male Tournament',
            'type' => Genre::Male->value,
            'start_date' => now(),
        ]);

        $winner = $maleTournament->simulate($players, Genre::Male->value);

        $maleTournament->winner()->associate($winner);

        $maleTournament->save();

        $this->info("Game winner: $winner->name");
    }
}
