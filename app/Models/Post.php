<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'lead_paragraph',
        'description',
        'image',
        'league_id',
        'slug',
        'user_id',
        'exkluzivni',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
        static::updating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'post_team', 'post_id', 'team_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
