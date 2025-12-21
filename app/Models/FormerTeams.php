<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormerTeams extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'former_teams';

    protected $fillable = [
        'former_id',
        'team_id',
        'deleted_at'
    ];
}
