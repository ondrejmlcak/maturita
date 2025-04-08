<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utkani extends Model
{
    use HasFactory;

    protected $table = 'matches';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'match_id',
        'home_team',
        'away_team',
        'score',
        'status',
        'start_time',
        'minutes',
        'league',
    ];

    public function bets()
    {
        return $this->hasMany(Bet::class, 'match_id', 'id');
    }

}
