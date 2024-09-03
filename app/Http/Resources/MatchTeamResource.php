<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role,
            'score' => $this->score,
            'winner' => $this->winner,
            'match' => [
                'id' => $this->match->id,
                'date' => $this->match->date,
                'location' => $this->match->location,
                'stadium' => $this->match->stadium,
                'league' => $this->match->league,
            ],
            'team' => [
                'id' => $this->team->id,
                'name' => $this->team->name,
                'slug' => $this->team->slug,
            ]
        ];
    }
}
