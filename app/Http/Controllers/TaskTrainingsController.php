<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Trainings;
use App\Models\TaskTrainings;
use App\Models\PmStatus;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTrainingsController extends Controller
{
    use SoftDeletes;

    /**
     * Show form to add required trainings to a task
     */
    public function addTraining($task_id)
    {
        $task = Task::findOrFail($task_id);

        // Get trainings from user's teams that are not already required
        $availableTrainings = Trainings::whereIn('id', function($query) {
                                  $query->select('training_id')
                                        ->from('training_teams')
                                        ->whereNull('training_teams.deleted_at')
                                        ->whereIn('team_id', function($subQuery) {
                                            $subQuery->select('team_id')
                                                ->from('teams_users')
                                                ->where('user_id', auth()->id())
                                                ->whereNull('teams_users.deleted_at');
                                        });
                              })
                              ->whereNotIn('id', function($query) use ($task_id) {
                                  $query->select('training_id')
                                        ->from('task_trainings')
                                        ->where('task_id', $task_id)
                                        ->whereNull('deleted_at');
                              })
                              ->get();

        $existingTrainings = $task->requiredTrainings;

        // Get all possible statuses from pm_status
        $statuses = PmStatus::all();

        return view('tasks.addTraining', [
            'task' => $task,
            'availableTrainings' => $availableTrainings,
            'existingTrainings' => $existingTrainings,
            'statuses' => $statuses
        ]);
    }

    /**
     * Store new training requirement
     */
    public function store($task_id, Request $request)
    {
        $task = Task::findOrFail($task_id);

        if ($request->training_ids && is_array($request->training_ids)) {
            foreach ($request->training_ids as $training_id) {
                $taskTraining = new TaskTrainings();
                $taskTraining->task_id = $task_id;
                $taskTraining->training_id = $training_id;
                $taskTraining->required_for_status = $request->required_for_status;
                $taskTraining->save();
            }
        }

        return redirect()->route('tasks.view', ['id' => $task_id]);
    }

    /**
     * Remove training requirement
     */
    public function remove($id)
    {
        $taskTraining = TaskTrainings::findOrFail($id);
        $taskId = $taskTraining->task_id;
        $taskTraining->delete();

        return redirect()->route('tasks.view', ['id' => $taskId]);
    }
}
