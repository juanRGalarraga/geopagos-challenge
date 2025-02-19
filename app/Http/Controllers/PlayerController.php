<?php

namespace App\Http\Controllers;

use App\Enums\Genre;
use App\Models\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\info(
    title: 'Player API',
    version: '1.0.0',
    description: 'API to manage players'
)]
class PlayerController extends Controller
{
    #[OA\Get(
        path: "/player",
        summary: "Gets a list of players, optionally filtered",
        parameters: [
            new OA\Parameter(
                name: "genre",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string"),
                example: "male"
            )
        ],
        tags: ["Players"]
    )]
    #[OA\Response(
        response: 200,
        description: "List of players retrieved successfully",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "items",
                    type: "array",
                    items: new OA\Items(type: "object"),
                    example: '[{"id": 1, "name": "John Doe", "genre": "male"}]'
                )
            ]
        )
    )]
    public function index(Request $request) : JsonResponse
    {
        $query = Player::query();
        $genre = $request->input('genre');
        if(Genre::tryFrom($genre) !== null){
            $query->where('genre', $genre);
        }
        return response()->json([
            'items' => $query->get()
        ]);
    }

    #[OA\Post(
        path: "/player",
        summary: "Creates a new player",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "John Doe"
                    ),
                    new OA\Property(
                        property: "skill_level",
                        type: "integer",
                        example: 25
                    ),
                    new OA\Property(
                        property: "genre",
                        type: "string",
                        example: "male"
                    ),
                    new OA\Property(
                        property: "strong",
                        description:"Apply if the genre is M",
                        type: "float",
                        example: 13
                    ),
                    new OA\Property(
                        property: "speed",
                        description:"Apply if the genre is M",
                        type: "float",
                        example: 15.4
                    ),
                    new OA\Property(
                        property: "reaction_time",
                        description:"Apply if the genre is F",
                        type: "integer",
                        example: 13.3
                    ),
                ]
            )
        ),
        tags: ["Players"]
    )]
    #[OA\Response(
        response: 201,
        description: "Player created successfully",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "message",
                    type: "string",
                    example: "Player created successfully"
                ),
                new OA\Property(
                    property: "player",
                    type: "object",
                    example: '{"id": 1, "name": "John Doe", "skill_level": 25, "genre": "male", "strong": 13, "speed": 15.4, "reaction_time": 13.3}'
                )
            ]
        )
    )]
    public function store(Request $request): JsonResponse {
        $player = Player::create($request->all());
        return response()->json([
            'message' => 'Player created successfully',
            'player' => $player
        ], 201);
    }
}