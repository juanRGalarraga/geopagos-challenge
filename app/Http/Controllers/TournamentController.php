<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\TournamentStoreRequest;
use App\Http\Requests\TournamentSimulateRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class TournamentController extends Controller
{
     #[OA\Post(
        path: "/api/tournament",
        summary: "Create a new tournament",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Summer Tournament"
                    ),
                    new OA\Property(
                        property: "type",
                        type: "string",
                        description: "Choose a Male of Female tournament",
                        example: "M"
                    )
                ]
            )
        ),
        tags: ["Tournament"]
    )]
    #[OA\Response(
        response: 201,
        description: "Tournament created successfully",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "message",
                    type: "string",
                    example: "Tournament created successfully"
                ),
                new OA\Property(
                    property: "tournament",
                    type: "object",
                )
            ]
        )
    )]
    
    #[OA\Response(
        response: 400,
        description: "Invalid request",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "error",
                    type: "string",
                    example: "The type is invalid"
                )
            ]
        )
    )]
    public function store(TournamentStoreRequest $request): JsonResponse
    {
        $name = $request->string('name');
        $type = $request->string('type');

        $createdTournament = Tournament::create([
            'name' => $name,
            'type' => $type,
        ]);

        return response()->json([
            'message' => 'Tournament created successfully',
            'tournament' => $createdTournament
        ], 201);
    }

    #[OA\Post(
        path: "/api/tournament/simulate",
        summary: "Simulate a tournament and return the winner",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "tournament_id",
                        type: "integer",
                        example: 1
                    ),
                    new OA\Property(
                        property: "players",
                        type: "array",
                        items: new OA\Items(type: "integer"),
                        example: [1, 2, 3, 4]
                    )
                ]
            )
        ),
        tags: ["Tournament"]
    )]
    #[OA\Response(
        response: 200,
        description: "Tournament simulated successfully",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "message",
                    type: "string",
                    example: "Tournament simulated successfully"
                ),
                new OA\Property(
                    property: "winner",
                    type: "string",
                    example: "John Doe"
                ),
                new OA\Property(
                    property: "tournament",
                    type: "string",
                    example: "Spring Championship"
                )
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: "Invalid Request",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "error",
                    type: "string",
                    example: "Invalid tournament ID"
                )
            ]
        )
    )]
    public function simulate(TournamentSimulateRequest $request): JsonResponse
    {
        $tournamentId = $request->integer('tournament_id', 0);
        $players = $request->collect('players');

        $tournament = Tournament::find($tournamentId);

        $tournament->update([
            'start_date' => now(),
        ]);

        $players = $players->map(function ($player) {
            return Player::find($player);
        });

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
        
        return response()->json([
            'message' => 'Tournament simulated successfully',
            'winner' => $players->first()->name,
            'tournament' => $tournament->name
        ], 200);
    }
}
