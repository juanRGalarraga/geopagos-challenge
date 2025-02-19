<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidPlayerCount;
use App\Models\Tournament;
use App\Models\Player;
use Illuminate\Http\Exceptions\HttpResponseException;

class TournamentSimulateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

     /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }

    public function withValidator(\Illuminate\Validation\Validator $validator){

        $validator->after(function ($validator) {
            $tournamentId = $this->input('tournament_id');
            $players = $this->collect('players');

            $tournament = Tournament::find($tournamentId);
            
            if (!$tournament) {
                $validator->errors()->add('tournament_id', 'Tournament not found');
                return;
            }

            $players = $players->map(function ($playerId) {
                $seekedPlayer = Player::find($playerId);
                return $seekedPlayer?->id ? $seekedPlayer : $playerId;
            });

            $playersNotFound = new \Illuminate\Database\Eloquent\Collection();
            $players->map(function ($player) use ($validator, $playersNotFound) {
                if( !($player instanceof Player) ){
                    $playersNotFound->push($player);
                    $validator->errors()->add('players', "Player with id {$player} not found");
                }
            });

            if($playersNotFound->isNotEmpty()){
                return;
            }

            $invalidPlayers = $players->filter(function ($player) use ($tournament) {
                return !$tournament->validatePlayer($player, $tournament->type);
            });

            if($invalidPlayers->isNotEmpty()){
                $validator->errors()->add('players', 
                "The following players must be of gender '{$tournament->type}': " . $invalidPlayers->pluck('id')->join(', '));
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tournament_id' => 'required|integer',
            'players' => ['required', 'array', new ValidPlayerCount],
            'players.*' => 'required|integer',
        ];
    }
}
