<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substitution extends Model
{
    use HasFactory;

    protected $fillable = ['zapas_id', 'home_player_id', 'away_player_id', 'minute'];

    public function zapas()
    {
        return $this->belongsTo(Zapas::class);
    }
}

