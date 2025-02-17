<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory;

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
    
    public function getScore(){
        return match ($this->genre) {
            'M' => $this->getScoreForMale(),
            'F' => $this->getScoreForFemale(),
        };
    }

    private function getScoreForMale() : float{
        //Lucky points works like a dice roll,
        //it can be any number between 1 and 20
        return $this->skill_level + $this->speed + $this->strong +
        $this->getLuckyPoints();
    }

    private function getScoreForFemale() : float{
        return $this->skill_level + $this->reaction_time +
        $this->getLuckyPoints();
    }

    private function getLuckyPoints() : float{
        return rand(1, 20);
    }

}
