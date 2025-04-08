<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchTimeline extends Model
{
    use HasFactory;

    protected $table = 'match_timeline';

    protected $fillable = [
        'match_id',
        'team_id',
        'event_type',
        'minute',
        'player_name',
    ];

    public const EVENT_TYPES = [
        'goal' => 'Gól',
        'penalty' => 'Proměněná penalta',
        'yellow_card' => 'Žlutá karta',
        'red_card' => 'Červená karta',
        'substitution' => 'Střídání',
        'penalty_miss' => 'Neproměněná penalta',
        'own_goal' => 'Vlastní gól',
        'assist' => 'Asistence',
    ];

    public function match()
    {
        return $this->belongsTo(Zapas::class, 'match_id');  // Zde změň 'match_id' na správný vztah s tabulkou 'zapas'
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
