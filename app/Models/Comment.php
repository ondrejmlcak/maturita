<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'home_score',
        'away_score',
        'status',
        'stadium',
        'fans_count',
        'referee',
        'home_lineup',
        'away_lineup',
        'home_substitutes',
        'away_substitutes',
        'commentator_id',
        'league_id',
        'match_date',
        'round',
    ];

    public function zapas()
    {
        return $this->belongsTo(Zapas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


