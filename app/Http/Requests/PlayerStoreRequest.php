<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Enums\Genre;
use Illuminate\Validation\Rules\Enum;

class PlayerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skill_level' => 'required||between:0,100',
            'name' => 'required|string',
            'genre' => ['required', new Enum(Genre::class )]
        ];
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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes('strength', 'required|integer', function ($input) {
            return $input->genre === Genre::Male->value;
        });

        $validator->sometimes('speed', 'required|integer', function ($input) {
            return $input->genre === Genre::Male->value;
        });

        $validator->sometimes('reaction_time', 'required|integer', function ($input) {
            return $input->genre === Genre::Female->value;
        });
    }
}
