<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CallingCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'character_summary',
        'best_attack_summary',
        'image_url',
        'share_token',
    ];

    protected $casts = [
        'character_summary' => 'array',
        'best_attack_summary' => 'array',
    ];

    /**
     * The game this calling card belongs to
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * The user this calling card belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique share token
     */
    public static function generateShareToken(): string
    {
        do {
            $token = Str::random(32);
        } while (self::where('share_token', $token)->exists());

        return $token;
    }

    /**
     * Get calling cards for a specific game
     */
    public function scopeForGame($query, Game $game)
    {
        return $query->where('game_id', $game->id);
    }

    /**
     * Get calling cards for a specific user
     */
    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Find by share token
     */
    public function scopeByShareToken($query, string $token)
    {
        return $query->where('share_token', $token);
    }

    /**
     * Get the sharing URL
     */
    public function getShareUrl(): string
    {
        return url('/shared/calling-card/' . $this->share_token);
    }
}
