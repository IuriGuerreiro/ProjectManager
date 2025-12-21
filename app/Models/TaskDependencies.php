<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskDependencies extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'task_dependencies';

    protected $fillable = [
        'task_id',
        'depends_on_task_id',
        'deleted_at'
    ];
}
