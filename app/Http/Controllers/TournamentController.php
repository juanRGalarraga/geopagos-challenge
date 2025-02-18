<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Enums\Genre;
use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Requests\TournamentSimulateRequest;

class TournamentController extends Controller
{

    public function store(TournamentStoreRequest $request): Response
    {
        $name = $request->input('name');
        $type = $request->input('type');

        $createdTournament = Tournament::create([
            'name' => $name,
            'type' => $type,
        ]);

        return response($createdTournament, 201);
    }

    public function simulate(TournamentSimulateRequest $request): Response
    {
        $tournamentId = $request->integer('tournament_id', 0);
        $players = $request->collect('players');
        $tournament = Tournament::findOrFail($tournamentId);

        $tournament->update([
            'start_date' => now(),
        ]);

        $players = $players->map(function ($player) {
            return Player::findOrFail($player);
        });

        $invalidPlayers = $players->filter(function ($player) use ($tournament) {
            return !$tournament->validatePlayer($player, $tournament->type);
        });

        if ($invalidPlayers->isNotEmpty()) {
            return response()->json([
                'message' => "The following players must be of gender '{$tournament->type}': " . $invalidPlayers->pluck('id')->join(', ')
            ], 400);
        }
        //When the number of players are 1, this means that we have the winner
        while ($players->count() > 1) {
            $winners = new Collection();
            for ($i = 0; $i < $players->count(); $i += 2) {

                $tournament->actualRound++;
                
                $playedGame = Game::play(
                    player1: $players[$i],
                    player2: $players[$i + 1],
                    tournament: $tournament
                );
                
                $winners->push($playedGame->winner);
            }
            //This contains the winners of the current round
            $players = $winners;
        }
        
        $tournament->winner()->associate($players->first());

        $tournament->save();
        
        return response()->json($tournament->winner, 200);
    }
}
