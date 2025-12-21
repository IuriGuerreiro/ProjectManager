<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingTeams extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'training_teams';

    protected $fillable = [
        'training_id',
        'team_id',
        'deleted_at'
    ];
}
