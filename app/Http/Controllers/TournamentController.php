<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Participation;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    
    public function create(string $type, array $players){

        $playersCount = count($players);
        if($playersCount % 2 != 0){
            throw new \InvalidArgumentException('Number of players must be even');
        }

        Db::transaction(function () use ($type, $players) {
            $tournament = new Tournament();
            $tournament->type = $type;
            $tournament->save();

            foreach ($players as $playerId) {

                $player = Player::find($playerId);

                $participation = new Participation();
                $participation->tournament_id = $tournament->id;

                if($type !== $player->genre){
                    throw new \InvalidArgumentException('Player genre does not match tournament type');
                }

                $participation->player_id = $playerId;
                $participation->save();
            }
        });
    }
}
