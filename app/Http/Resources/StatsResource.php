<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatsResource extends JsonResource
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
            'player' => [
                'id' => $this->player->id,
                'name' => $this->player->name,
                'position' => $this->player->position,
            ],
            'stats' => [
                'min' => $this->min,
                'pts' => $this->pts,
                'reb' => $this->reb,
                'ast' => $this->ast,
                'blk' => $this->blk,
                'stl' => $this->stl
            ],
            'match' => [
                'id' => $this->matchTeam->match->id,
                'date' => $this->matchTeam->match->date,
            ],
            'match_teams' => $this->matchTeam->match->matchesTeams->map(function ($team) {
                return [
                    'id' => $team->id,
                    'role' => $team->role,
                    'score' => $team->score,
                    'winner' => $team->winner,
                    'team' => [
                        'id' => $team->team->id,
                        'name' => $team->team->name,
                        'slug' => $team->team->slug,
                    ],
                ];
            }),
        ];
    }
}
