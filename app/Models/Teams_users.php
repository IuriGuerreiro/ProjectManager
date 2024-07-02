<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teams_users extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'teams_users';

    protected $fillable = [
        'user_id',
        'team_id',
        'deleted_at'
    ];
}
