<?php

namespace App\Models;

use App\Exceptions\InvalidPlayerException;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;
use App\Models\Player;

class Game extends Model
{
    
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function player1()
    {
        return $this->belongsTo(Player::class);
    }

    public function player2()
    {
        return $this->belongsTo(Player::class);
    }

    public function winner()
    {
        return $this->belongsTo(Player::class);
    }

    public function play(Player $player1, Player $player2, Tournament $tournament) : Player {
        
        $score1 = $player1->getScore();
        $score2 = $player2->getScore();

        $this->tournament_id = $tournament->id;
        $this->round = $tournament->actualRound;
        $this->player1_id = $player1->id;
        $this->player2_id = $player2->id;

        $winner = ($score1 > $score2) ? $this->player1 : $this->player2;
        $this->winner_id = $winner->id;

        return $winner;
    }
}
