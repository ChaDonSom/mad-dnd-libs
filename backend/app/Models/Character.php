<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'description',
        'madlibs_source',
        'image_url',
        'is_available',
    ];

    protected $casts = [
        'madlibs_source' => 'array',
        'is_available' => 'boolean',
    ];

    /**
     * The game this character belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Player loadouts using this character
     */
    public function playerLoadouts(): HasMany
    {
        return $this->hasMany(PlayerLoadout::class);
    }

    /**
     * Get available characters only
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Get characters for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }
}
