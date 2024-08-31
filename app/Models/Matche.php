<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory, HasUuids;

    public $guarded = [];

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function matchesTeams()
    {
        return $this->hasMany(MatchTeam::class, 'match_id');
    }
}
