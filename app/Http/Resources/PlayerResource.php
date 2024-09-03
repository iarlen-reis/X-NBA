<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'name' => $this->name,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'league' => $this->league,
            'position' => $this->position,
            'average' => $this->when($this->average, function () {
                return [
                    'min' => $this->average['min'],
                    'pts' => $this->average['pts'],
                    'reb' => $this->average['reb'],
                    'ast' => $this->average['ast'],
                    'stl' => $this->average['stl'],
                    'blk' => $this->average['blk'],
                ];
            }),
            'team' => $this->when($this->team, function () {
                return [
                    'id' => $this->team['id'],
                    'name' => $this->team['name'],
                    'slug' => $this->team['slug'],
                ];
            }),
        ];
    }
}
