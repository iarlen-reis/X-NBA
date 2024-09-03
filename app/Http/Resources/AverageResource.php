<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AverageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'player' => [
                'id' => $this->player->id,
                'name' => $this->player->name,
                'position' => $this->player->position,
                'league' => $this->player->league
            ],
            'average' => [
                'min' => $this->min,
                'id' => $this->id,
                'pts' => $this->pts,
                'reb' => $this->reb,
                'ast' => $this->ast,
                'stl' => $this->stl,
                'blk' => $this->blk,
            ]
        ];
    }
}
