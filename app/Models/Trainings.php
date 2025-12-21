<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainings extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'training_code',
        'trainings_designation',
        'description',
        'status',
        'created_by',
        'deleted_at'
    ];

    /**
     * Get the user who created this training
     */
    public function creator()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    /**
     * Get teams that have access to this training
     */
    public function teams()
    {
        return $this->belongsToMany(Teams::class, 'training_teams', 'training_id', 'team_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at')
                    ->whereNull('training_teams.deleted_at')
                    ->whereNull('teams.deleted_at');
    }

    /**
     * Get formers assigned to this training
     */
    public function formers()
    {
        return $this->belongsToMany(Formers::class, 'training_formers', 'train_id', 'former_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at')
                    ->whereNull('training_formers.deleted_at')
                    ->whereNull('formers.deleted_at');
    }

    /**
     * Get tasks that require this training
     */
    public function requiredByTasks()
    {
        return $this->belongsToMany(Task::class, 'task_trainings', 'training_id', 'task_id')
                    ->withTimestamps()
                    ->withPivot('required_for_status', 'deleted_at');
    }
}
