<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Teams extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'teams';

    protected $fillable = [
        'team_designation',
        'team_function',
        'invite_token',
        'invite_expires_at',
        'deleted_at'
    ];

    protected $casts = [
        'invite_expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            if (empty($team->invite_token)) {
                $team->invite_token = static::generateUniqueToken();
                $team->invite_expires_at = now()->addHours(24); // 24 hour expiration
            }
        });
    }

    public static function generateUniqueToken()
    {
        do {
            $token = Str::random(32);
        } while (static::where('invite_token', $token)->exists());

        return $token;
    }

    public function regenerateInviteToken($hours = 24)
    {
        $this->invite_token = static::generateUniqueToken();
        $this->invite_expires_at = now()->addHours($hours);
        $this->save();
        return $this->invite_token;
    }

    public function isInviteExpired()
    {
        return $this->invite_expires_at && $this->invite_expires_at->isPast();
    }

    public function isInviteValid()
    {
        return $this->invite_token && !$this->isInviteExpired();
    }

    public function users()
    {
        return $this->belongsToMany(Users::class, 'teams_users', 'team_id', 'user_id')
            ->withTimestamps()
            ->wherePivot('deleted_at', null);
    }
}
