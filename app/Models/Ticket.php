<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stake', 'final_win', 'status'];

    /**
     * Tiket má jednu sázku.
     */
    public function bet()
    {
        return $this->hasOne(Bet::class);
    }
    public function bets()
    {
        return $this->hasMany(Bet::class);
    }


    /**
     * Získat data o zápase přímo, bez ohledu na strukturu
     */
    public function getMatchInfoAttribute()
    {
        if ($this->match) {
            $match = $this->match;
        }

        elseif ($this->bet && $this->bet->match) {
            $match = $this->bet->match;
        }
        else {
            return [
                'league' => 'Neznámá liga',
                'home_team' => 'Neznámý tým',
                'away_team' => 'Neznámý tým',
                'score' => '0-0',
                'status' => 'Neznámý stav',
            ];
        }

        return [
            'league' => $match->league ?? 'Neznámá liga',
            'home_team' => $match->home_team ?? 'Neznámý tým',
            'away_team' => $match->away_team ?? 'Neznámý tým',
            'score' => $match->score ?? '0-0',
            'status' => $match->status ?? 'Neznámý stav',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tiket je propojen s více zápasy přes sázky.
     */
    public function match()
    {
        return $this->hasOneThrough(
            Utkani::class,
            Bet::class,
            'ticket_id',
            'id',
            'id',
            'match_id'
        );
    }

    public function calculateWin()
    {
        $totalOdds = 1.0;
        foreach ($this->bets as $bet) {
            $totalOdds *= (float) $bet->odd;
        }

        return round($this->stake * $totalOdds, 2);
    }


}
