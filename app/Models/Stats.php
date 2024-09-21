<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stats extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function matchTeam(): BelongsTo
    {
        return $this->belongsTo(MatchTeam::class);
    }
}
