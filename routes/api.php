<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::put('/tournament', [TournamentController::class, 'store']);
Route::post('/tournament/simulate', [TournamentController::class, 'simulate']);