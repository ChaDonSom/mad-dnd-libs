<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerLoadout extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'character_id',
        'weapon_id',
        'attack_id',
        'selection_round',
        'is_current',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    /**
     * The game this loadout belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The user who owns this loadout
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The character in this loadout
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * The weapon in this loadout
     */
    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class);
    }

    /**
     * The attack in this loadout
     */
    public function attack(): BelongsTo
    {
        return $this->belongsTo(Attack::class);
    }

    /**
     * Get current loadouts only
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Get loadouts for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }

    /**
     * Get loadouts by selection round
     */
    public function scopeByRound($query, int $round)
    {
        return $query->where('selection_round', $round);
    }

    /**
     * Check if loadout is complete
     */
    public function isComplete(): bool
    {
        return $this->character_id && $this->weapon_id && $this->attack_id;
    }
}
