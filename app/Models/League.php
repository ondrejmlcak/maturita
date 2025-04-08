<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($league) {
            $league->slug = Str::slug($league->name);
        });

        static::updating(function ($league) {
            $league->slug = Str::slug($league->name);
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
