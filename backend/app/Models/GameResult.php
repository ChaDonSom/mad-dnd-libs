<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'result',
        'total_damage_dealt',
        'rounds_completed',
        'mvp_user_id',
        'team_score',
    ];

    // Result constants
    const RESULT_VICTORY = 'victory';
    const RESULT_DEFEAT = 'defeat';

    /**
     * The game this result belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The MVP user
     */
    public function mvpUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mvp_user_id');
    }

    /**
     * Get victories only
     */
    public function scopeVictories($query)
    {
        return $query->where('result', self::RESULT_VICTORY);
    }

    /**
     * Get defeats only
     */
    public function scopeDefeats($query)
    {
        return $query->where('result', self::RESULT_DEFEAT);
    }

    /**
     * Check if result was a victory
     */
    public function isVictory(): bool
    {
        return $this->result === self::RESULT_VICTORY;
    }

    /**
     * Check if result was a defeat
     */
    public function isDefeat(): bool
    {
        return $this->result === self::RESULT_DEFEAT;
    }
}
