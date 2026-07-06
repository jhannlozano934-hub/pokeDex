<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'session_id', 'pokemon_id', 'pokemon_name', 'sprite_url'];

    public function scopeForCurrentVisitor(Builder $query): Builder
    {
        return auth()->check()
            ? $query->where('user_id', auth()->id())
            : $query->where('session_id', session()->getId());
    }
}