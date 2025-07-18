<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_user_id',
        'room_code',
        'name',
        'status',
        'current_phase',
        'configuration',
        'max_players',
    ];

    protected $casts = [
        'configuration' => 'array',
    ];

    // Game status constants
    const STATUS_WAITING = 'waiting';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_ABANDONED = 'abandoned';

    // Game phase constants
    const PHASE_SUBMISSION = 'submission';
    const PHASE_SELECTION = 'selection';
    const PHASE_VOTING = 'voting';
    const PHASE_BATTLE = 'battle';
    const PHASE_SUMMARY = 'summary';

    /**
     * The host of this game
     */
    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    /**
     * All participants in this game
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_participants')
            ->withPivot(['role', 'status', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Madlibs submissions for this game
     */
    public function madlibsSubmissions(): HasMany
    {
        return $this->hasMany(MadlibsSubmission::class);
    }

    /**
     * Generated characters for this game
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    /**
     * Generated weapons for this game
     */
    public function weapons(): HasMany
    {
        return $this->hasMany(Weapon::class);
    }

    /**
     * Generated attacks for this game
     */
    public function attacks(): HasMany
    {
        return $this->hasMany(Attack::class);
    }

    /**
     * Player loadouts for this game
     */
    public function playerLoadouts(): HasMany
    {
        return $this->hasMany(PlayerLoadout::class);
    }

    /**
     * Votes cast in this game
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Boss for this game
     */
    public function boss(): HasOne
    {
        return $this->hasOne(Boss::class);
    }

    /**
     * Battle rounds for this game
     */
    public function battleRounds(): HasMany
    {
        return $this->hasMany(BattleRound::class);
    }

    /**
     * Game result
     */
    public function result(): HasOne
    {
        return $this->hasOne(GameResult::class);
    }

    /**
     * Superlatives awarded in this game
     */
    public function superlatives(): HasMany
    {
        return $this->hasMany(Superlative::class);
    }

    /**
     * Generate a unique room code
     */
    public static function generateRoomCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6));
        } while (self::where('room_code', $code)->exists());

        return $code;
    }

    /**
     * Check if user is the host of this game
     */
    public function isHost(User $user): bool
    {
        return $this->host_user_id === $user->id;
    }

    /**
     * Check if user is a participant in this game
     */
    public function hasParticipant(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    /**
     * Get active participants only
     */
    public function activeParticipants(): BelongsToMany
    {
        return $this->participants()->wherePivot('status', 'active');
    }
}
