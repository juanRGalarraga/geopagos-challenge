<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Tournament extends Model
{
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

    public function create(string $type, array $players){

        $this->validatePlayersCount(count($players) );
        $this->validatePlayers($type, $players);

        Db::transaction(function () use ($type, $players) {

            $tournament = new Tournament();

            $tournament->type = $type;

            $tournament->winner = $this->simulate($players, $tournament);

            $tournament->save();
        });
    }

    private function validatePlayersCount(int $playersCount){
        //If playersCount is a power of 2 the bitwise operation will return 0
        return ($playersCount & ($playersCount - 1)) === 0 && $playersCount > 0;
    }

    private function validatePlayers(string $type, array $players){
        foreach($players as $playerId){
            $player = Player::find($playerId);
            if($player == null){
                throw new \InvalidArgumentException('Player with id ' . $playerId . ' does not exist');
            }
    
            if($player->genre !== $type){
                throw new \InvalidArgumentException('Player with id ' . $playerId . ' is not of type ' . $type);
            }
        }
    }

    private function simulate(array $arrayOfPlayer, Tournament $tournament) : Player {

        $players = new Collection($arrayOfPlayer);

        $i = 0;

        while($players->count() > 1) {
            $winners = new Collection();
            for($i = 0; $i < $players->count(); $i += 2){

                $game = new Game();

                $winner = $game->play(
                    player1: $players[$i],
                    player2: $players[$i + 1],
                    tournament: $tournament
                );

                $game->save();

                $winners->push($winner);

            }
            $participants = $winners;
        }

        return $participants->first();
    }
}
