<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskDependencies;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskDependenciesController extends Controller
{
    use SoftDeletes;

    /**
     * Show form to add dependencies to a task
     */
    public function addDependency($task_id)
    {
        $task = Task::findOrFail($task_id);

        // Get all tasks in the same project, excluding self and already-dependent tasks
        $availableTasks = Task::where('project_id', $task->project_id)
                              ->where('id', '!=', $task_id)
                              ->whereNotIn('id', function($query) use ($task_id) {
                                  $query->select('depends_on_task_id')
                                        ->from('task_dependencies')
                                        ->where('task_id', $task_id)
                                        ->whereNull('deleted_at');
                              })
                              ->get();

        $existingDependencies = $task->dependencies;

        return view('tasks.addDependency', [
            'task' => $task,
            'availableTasks' => $availableTasks,
            'existingDependencies' => $existingDependencies
        ]);
    }

    /**
     * Store new dependency
     */
    public function store($task_id, Request $request)
    {
        $task = Task::findOrFail($task_id);
        $dependsOnTaskId = $request->input('depends_on_task_id');

        // Validate circular dependency
        if ($task->wouldCreateCircularDependency($dependsOnTaskId)) {
            return redirect()->back()->withErrors([
                'dependency' => 'Esta dependência criaria uma dependência circular.'
            ]);
        }

        $dependency = new TaskDependencies();
        $dependency->task_id = $task_id;
        $dependency->depends_on_task_id = $dependsOnTaskId;
        $dependency->save();

        return redirect()->route('tasks.view', ['id' => $task_id]);
    }

    /**
     * Remove dependency
     */
    public function remove($id)
    {
        $dependency = TaskDependencies::findOrFail($id);
        $taskId = $dependency->task_id;
        $dependency->delete();

        return redirect()->route('tasks.view', ['id' => $taskId]);
    }
}
