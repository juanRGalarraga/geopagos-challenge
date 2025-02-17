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

    public function play(){

        if(!($this->player1 instanceof Player)){
            throw new InvalidPlayerException('Player 1 is not a valid player');
        }

        if(!($this->player2 instanceof Player)){
            throw new InvalidPlayerException('Player 2 is not a valid player');
        }

        $score1 = $this->player1->getScore();
        $score2 = $this->player2->getScore();

        $winner = ($score1 > $score2) ? $this->player1 : $this->player2;
        $this->winner_id = $winner;

        return $winner;
    }
}
