<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Tournament extends Model
{

    protected $fillable = ['name', 'type', 'winner', 'start_date'];

    public int $actualRound = 0;

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'participations');
    }

    public function winner()
    {
        return $this->belongsTo(Player::class);
    }

    private function validatePlayersCount(int $playersCount){
        //If playersCount is a power of 2 the bitwise operation will return 0
        return ($playersCount & ($playersCount - 1)) === 0 && $playersCount > 0;
    }

    private function validatePlayers(string $type, array $players){
        foreach($players as $player){
            if($player == null){
                throw new \InvalidArgumentException("Player does not exist");
            }
            if($player->genre !== $type){
                throw new \InvalidArgumentException("Player with id {$player->id} is not of type $type");
            }
        }
    }

    public function simulate(array $arrayOfPlayer, string $type): Player
    {
        $this->validatePlayersCount(count($arrayOfPlayer) );
        $this->validatePlayers($type, $arrayOfPlayer);
        $players = new Collection($arrayOfPlayer);

        //When the number of players are 1, this means that we have a winner
        while ($players->count() > 1) {
            $winners = new Collection();
            for ($i = 0; $i < $players->count(); $i += 2) {
                $this->actualRound++;
                
                $game = new Game();
                $winner = $game->play(
                    player1: $players[$i],
                    player2: $players[$i + 1],
                    tournament: $this
                );
                $game->save();
                $winners->push($winner);
            }
            $players = $winners;
        }
        return $players->first();
    }
}
