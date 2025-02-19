<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\PlayerController;


/**
 * @OA\Info(
 *     title="Geopagos Challenge API",
 *     version="1.0.0",
 *     description="API documentation for the Geopagos Challenge"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local server"
 * )
 */

Route::put('/tournament', [TournamentController::class, 'store']);
Route::post('/tournament/simulate', [TournamentController::class, 'simulate']);

Route::get('player', [PlayerController::class, 'index']);
Route::put('player', [PlayerController::class, 'store']);