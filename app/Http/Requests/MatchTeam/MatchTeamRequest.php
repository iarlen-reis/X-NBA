<?php

namespace App\Http\Requests\MatchTeam;

use Illuminate\Foundation\Http\FormRequest;

class MatchTeamRequest extends FormRequest
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
            'role' => 'required|string',
            'team_id' => 'required|string',
            'match_id' => 'required|string',
        ];
    }
}