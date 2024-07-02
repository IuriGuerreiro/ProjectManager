<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teams_projects extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'teams_projects';

    protected $fillable = [
        'project_id',
        'team_id',
        'deleted_at'
    ];
}
