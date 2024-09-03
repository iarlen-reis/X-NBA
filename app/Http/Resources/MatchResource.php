<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
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
            'date' => $this->date,
            'location' => $this->location,
            'stadium' => $this->stadium,
            'league' => $this->league,
            'matches_teams' => $this->matchesTeams->map(function ($team) {
                return [
                    'id' => $team->id,
                    'role' => $team->role,
                    'team' => [
                        'id' => $team->team->id,
                        'name' => $team->team->name,
                        'slug' => $team->team->slug,
                    ]
                ];
            }),
        ];
    }
}
