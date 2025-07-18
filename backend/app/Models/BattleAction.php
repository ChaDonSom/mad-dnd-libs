<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BattleAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'round_id',
        'user_id',
        'loadout_id',
        'dice_roll',
        'base_damage',
        'multiplier_bonus',
        'total_damage',
        'animation_data',
        'success_level',
    ];

    protected $casts = [
        'animation_data' => 'array',
        'multiplier_bonus' => 'decimal:2',
    ];

    // Success level constants
    const SUCCESS_CRITICAL = 'critical';
    const SUCCESS_HIT = 'hit';
    const SUCCESS_MISS = 'miss';

    /**
     * The game this action belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The round this action belongs to
     */
    public function round(): BelongsTo
    {
        return $this->belongsTo(BattleRound::class, 'round_id');
    }

    /**
     * The user who performed this action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The loadout used for this action
     */
    public function loadout(): BelongsTo
    {
        return $this->belongsTo(PlayerLoadout::class, 'loadout_id');
    }

    /**
     * Get successful actions only
     */
    public function scopeSuccessful($query)
    {
        return $query->whereIn('success_level', [self::SUCCESS_HIT, self::SUCCESS_CRITICAL]);
    }

    /**
     * Get critical hits only
     */
    public function scopeCritical($query)
    {
        return $query->where('success_level', self::SUCCESS_CRITICAL);
    }

    /**
     * Get misses only
     */
    public function scopeMisses($query)
    {
        return $query->where('success_level', self::SUCCESS_MISS);
    }

    /**
     * Check if action was successful
     */
    public function wasSuccessful(): bool
    {
        return in_array($this->success_level, [self::SUCCESS_HIT, self::SUCCESS_CRITICAL]);
    }

    /**
     * Check if action was a critical hit
     */
    public function wasCritical(): bool
    {
        return $this->success_level === self::SUCCESS_CRITICAL;
    }
}
