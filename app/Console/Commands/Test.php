<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Player;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

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
        $player = Player::find(13);
        $player2 = Player::find(17);
        $score = $player->getScoreForMale();
        $score2 = $player2->getScoreForMale();
        $this->info("Player1 score: $score");
        $this->info("Player2 score: $score2");
    }
}