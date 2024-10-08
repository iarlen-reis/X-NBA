<?php

namespace App\Http\Requests\Stats;

use Illuminate\Foundation\Http\FormRequest;

class StatsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'min' => 'required|integer',
            'pts' => 'required|integer',
            'reb' => 'required|integer',
            'ast' => 'required|integer',
            'blk' => 'required|integer',
            'stl' => 'required|integer',
            'player_id' => 'required|string',
            'match_team_id' => 'required|string',
        ];
    }
}
