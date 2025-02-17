<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;
use App\Models\Participation;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Tournament extends Model
{
    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
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

        $playersCount = count($players);
        $this->validatePlayersCount($playersCount);
        $this->validatePlayers($type, $players);

        Db::transaction(function () use ($type, $players) {
            $tournament = new Tournament();
            $tournament->type = $type;
            $tournament->save();

            $participants = new Collection($players);
            $i = 0;
            while($participants->count() > 1) { 

                $winners = new Collection();

                $game = new Game();
                $game->tournament_id = $tournament->id;
                $game->round = $i + 1;
                $game->player1_id = $players[$i];
                $game->player2_id = $players[$i + 1];
                $winner = $game->play();
                $game->save();

                $winners->push($winner);
            }
        });
    }

    private function validatePlayersCount(int $playersCount){
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
}
