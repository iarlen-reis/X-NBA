<?php

namespace App\Http\Requests\Average;

use Illuminate\Foundation\Http\FormRequest;

class AverageRequest extends FormRequest
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
            'min' => 'required|numeric',
            'pts' => 'required|numeric',
            'reb' => 'required|numeric',
            'ast' => 'required|numeric',
            'stl' => 'required|numeric',
            'blk' => 'required|numeric',
            'player_id' => 'required|string',
        ];
    }
}
