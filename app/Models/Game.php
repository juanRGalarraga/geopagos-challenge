<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;
use App\Models\Player;

class Game extends Model
{
    
    protected $fillable = ['tournament_id', 'round', 'player1_id', 'player2_id', 'winner_id'];

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

    public static function play(Player $player1, Player $player2, Tournament $tournament) : Game {

        $score1 = 0;
        $score2 = 0;
        do {
            //Meanwhile the scores are equal, we will play again
            $score1 = $player1->getScore();
            $score2 = $player2->getScore();
        } while ($score1 == $score2);

        $attributes = [
            'tournament_id' => $tournament->id,
            'round' => $tournament->actualRound,
            'player1_id' => $player1->id,
            'player2_id' => $player2->id
        ];

        $winner = ($score1 > $score2) ? $player1 : $player2;

        $attributes['winner_id'] = $winner->id;

        return Game::create($attributes);
    }
}
