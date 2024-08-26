<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchTeam extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'match_team';

    public $guarded = [];

    public function match()
    {
        return $this->belongsTo(Matche::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
