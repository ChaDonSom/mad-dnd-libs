<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attack extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'description',
        'madlibs_source',
        'animation_type',
        'is_available',
    ];

    protected $casts = [
        'madlibs_source' => 'array',
        'is_available' => 'boolean',
    ];

    // Animation type constants
    const ANIMATION_SLASH = 'slash';
    const ANIMATION_THRUST = 'thrust';
    const ANIMATION_MAGIC = 'magic';
    const ANIMATION_PROJECTILE = 'projectile';
    const ANIMATION_SPECIAL = 'special';

    /**
     * The game this attack belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Player loadouts using this attack
     */
    public function playerLoadouts(): HasMany
    {
        return $this->hasMany(PlayerLoadout::class);
    }

    /**
     * Battle actions using this attack
     */
    public function battleActions(): HasMany
    {
        return $this->hasMany(BattleAction::class);
    }

    /**
     * Get available attacks only
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Get attacks for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }

    /**
     * Get attacks by animation type
     */
    public function scopeByAnimationType($query, string $animationType)
    {
        return $query->where('animation_type', $animationType);
    }
}
