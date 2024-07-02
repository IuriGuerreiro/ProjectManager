<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectsUsers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'project_users';

    protected  $fillable = [
        'id',
        'task_id',
        'User_id',
        'deleted_at'
    ];
}
