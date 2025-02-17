<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
