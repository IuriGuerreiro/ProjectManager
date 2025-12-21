<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['task_code',
                            'task_designation',
                            'task_status',
                            'description',
                            'project_id',
                            'parent_task_id',
                            'completion_percentage',
                            'auto_update_status',
                            'deleted_at'
                        ];

    protected $table = 'tasks';

    /**
     * Always eager load these relationships
     */
    protected $with = ['project'];

    // ========== RELATIONSHIPS ==========

    /**
     * Get the parent task
     */
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    /**
     * Get all subtasks
     */
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    /**
     * Get tasks that this task depends on
     */
    public function dependencies()
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'task_id', 'depends_on_task_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

    /**
     * Get tasks that depend on this task
     */
    public function dependents()
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'depends_on_task_id', 'task_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

    /**
     * Get required trainings for this task
     */
    public function requiredTrainings()
    {
        return $this->belongsToMany(Trainings::class, 'task_trainings', 'task_id', 'training_id')
                    ->withTimestamps()
                    ->withPivot('required_for_status', 'deleted_at');
    }

    /**
     * Get the project this task belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get users assigned to this task
     */
    public function assignedUsers()
    {
        return $this->belongsToMany(Users::class, 'task_users', 'task_id', 'user_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

    // ========== BUSINESS LOGIC METHODS ==========

    /**
     * Check if all task dependencies are complete
     */
    public function areDependenciesComplete()
    {
        foreach ($this->dependencies as $dependency) {
            if ($dependency->task_status !== 'concluído') {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if assigned users have completed required trainings
     */
    public function areRequiredTrainingsComplete($newStatus = null)
    {
        $statusToCheck = $newStatus ?? $this->task_status;

        $requiredTrainings = $this->requiredTrainings()
                                 ->where(function($query) use ($statusToCheck) {
                                     $query->where('required_for_status', $statusToCheck)
                                           ->orWhereNull('required_for_status');
                                 })
                                 ->get();

        if ($requiredTrainings->isEmpty()) {
            return true;
        }

        $assignedUsers = $this->assignedUsers;

        if ($assignedUsers->isEmpty()) {
            return false; // No users assigned, can't complete trainings
        }

        foreach ($assignedUsers as $user) {
            foreach ($requiredTrainings as $training) {
                // Check if user completed this training
                $completed = TrainingUsers::where('users_id', $user->id)
                                          ->where('train_id', $training->id)
                                          ->whereNull('deleted_at')
                                          ->exists();
                if (!$completed) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Calculate completion percentage from subtasks
     */
    public function calculateCompletionPercentage()
    {
        $subtasks = $this->subtasks;

        if ($subtasks->isEmpty()) {
            // Leaf task - completion based on status
            return $this->task_status === 'concluído' ? 100.00 : 0.00;
        }

        $totalCompletion = 0;
        foreach ($subtasks as $subtask) {
            $totalCompletion += $subtask->completion_percentage;
        }

        return round($totalCompletion / $subtasks->count(), 2);
    }

    /**
     * Auto-update parent task status based on subtask completion
     */
    public function updateParentStatus()
    {
        if ($this->parent && $this->parent->auto_update_status) {
            $newCompletion = $this->parent->calculateCompletionPercentage();
            $this->parent->completion_percentage = $newCompletion;

            // Auto-update status based on completion
            if ($newCompletion == 100.00) {
                $this->parent->task_status = 'concluído';
            } elseif ($newCompletion > 0) {
                $this->parent->task_status = 'em progresso';
            }

            $this->parent->save();

            // Recursively update grandparent
            $this->parent->updateParentStatus();
        }
    }

    /**
     * Check if adding a dependency would create a circular dependency
     */
    public function wouldCreateCircularDependency($dependsOnTaskId)
    {
        $visited = [];
        return $this->detectCycle($dependsOnTaskId, $visited);
    }

    /**
     * Detect circular dependencies using depth-first search
     */
    private function detectCycle($taskId, &$visited)
    {
        if ($taskId == $this->id) {
            return true; // Circular dependency detected
        }

        if (in_array($taskId, $visited)) {
            return false; // Already checked this path
        }

        $visited[] = $taskId;

        $task = Task::find($taskId);
        if (!$task) {
            return false;
        }

        foreach ($task->dependencies as $dependency) {
            if ($this->detectCycle($dependency->id, $visited)) {
                return true;
            }
        }

        return false;
    }
}
