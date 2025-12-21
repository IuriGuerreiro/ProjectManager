<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTrainings extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'task_trainings';

    protected $fillable = [
        'task_id',
        'training_id',
        'required_for_status',
        'deleted_at'
    ];
}
