<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            $team->slug = Str::slug($team->name);
        });

        static::updating(function ($team) {
            $team->slug = Str::slug($team->name);
        });

        static::deleting(function ($team) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_team', 'team_id', 'post_id');
    }

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id');
    }

    public function timeline()
    {
        return $this->hasMany(MatchTimeline::class, 'match_id');
    }



    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
}
