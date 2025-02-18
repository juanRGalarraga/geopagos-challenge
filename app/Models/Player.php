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

    
    public function getScore(){
        return match ($this->genre) {
            'M' => $this->getScoreForMale(),
            'F' => $this->getScoreForFemale(),
        };
    }

    public function getScoreForMale() : float{
        //Lucky points works like a dice roll,
        //it can be any float between 1 and 20
        $skillLevel = 0.5 * $this->skill_level * $this->getLuckyPoints();
        $speed = 0.3 * $this->speed * $this->getLuckyPoints();
        $strong = 0.2 * $this->strong * $this->getLuckyPoints();
        print_r("Skill Level to {$this->name} : $skillLevel\n");
        return $skillLevel + $speed + $strong;
    }

    public function getScoreForFemale() : float{
        return (0.6 * $this->skill_level) + (0.4 * $this->reaction_time) * $this->getLuckyPoints();
    }

    private function getLuckyPoints() : float{
        return mt_rand(1, 50) / 100;
    }

}
