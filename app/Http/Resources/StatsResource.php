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
            'min' => $this->min,
            'pts' => $this->pts,
            'reb' => $this->reb,
            'ast' => $this->ast,
            'blk' => $this->blk,
            'stl' => $this->stl
        ];
    }
}
