<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;
use App\Models\Game;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tournament extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'type', 'winner', 'start_date'];

    public int $actualRound = 0;

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'participations');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function validatePlayer(Player $player, string $type): bool|Player{
        if($player->genre !== $type){
            return false;
        }
        return $player;
    }
}
