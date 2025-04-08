<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zapas extends Model
{
    use HasFactory;

    protected $table = 'zapas';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'home_score',
        'away_score',
        'status',
        'stadium',
        'fans_count',
        'referee',
        'commentator_id',
        'league_id',
        'match_date',
        'round_number',
        'home_lineup',
        'away_lineup',
        'home_substitutes',
        'away_substitutes',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function commentator()
    {
        return $this->belongsTo(User::class, 'commentator_id');
    }

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function timeline()
    {
        return $this->hasMany(MatchTimeline::class, 'match_id');
    }

}



