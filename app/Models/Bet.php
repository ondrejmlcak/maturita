<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'match_id', 'bet_type', 'odd'];

    /**
     * Sázka patří k jednomu tiketu.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Sázka patří k jednomu zápasu.
     */
    public function match()
    {
        return $this->belongsTo(Utkani::class, 'match_id', 'match_id');
    }

}
