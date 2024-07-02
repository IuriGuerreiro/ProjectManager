<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskUsers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'task_users';

    protected $fillable = [
        'task_id',
        'user_id',
        'deleted_at'
    ];
}
