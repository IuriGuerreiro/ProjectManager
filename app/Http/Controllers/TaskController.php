<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\PmStatus;
use App\Models\Taskusers;
use Illuminate\Support\Facades\Auth;


use Illuminate\Database\Eloquent\SoftDeletes;

class TaskController extends Controller
{

    use SoftDeletes;

    public function index(Request $request){
        // Get search query
        $search = $request->get('search');

        // Get only top-level tasks (no parent) with their project info
        $query = Task::select('tasks.*', 'projects.project_designation')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->whereNull('tasks.parent_task_id') // Only top-level tasks
                    ->whereIn('projects.id', function($query) {
                        $query->select('project_id')
                            ->from('teams_projects')
                            ->whereIn('team_id', function($subQuery) {
                                $subQuery->select('team_id')
                                    ->from('teams_users')
                                    ->where('user_id', Auth::id());
                            });
                    });

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('tasks.task_designation', 'LIKE', "%{$search}%")
                  ->orWhere('tasks.task_code', 'LIKE', "%{$search}%")
                  ->orWhere('tasks.description', 'LIKE', "%{$search}%")
                  ->orWhere('projects.project_designation', 'LIKE', "%{$search}%");
            });
        }

        $tasks = $query->orderByRaw("CASE
                        WHEN tasks.task_status = 'Em Curso' THEN 1
                        WHEN tasks.task_status = 'Em Pausa' THEN 2
                        WHEN tasks.task_status = 'Pendente' THEN 3
                        WHEN tasks.task_status = 'A Fazer' THEN 4
                        WHEN tasks.task_status = 'Concluído' THEN 5
                        ELSE 6
                    END")
                    ->orderBy('tasks.created_at', 'desc')
                    ->with($this->getNestedSubtasks())
                    ->get();

        $statuses = PmStatus::all();

        return view('tasks.index', ['tasks' => $tasks, 'statuses' => $statuses, 'search' => $search]);
    }

    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|string'
        ]);

        $task = Task::findOrFail($id);
        $task->task_status = $request->status;
        $task->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    /**
     * Recursively load all nested subtasks
     */
    private function getNestedSubtasks($depth = 10)
    {
        $relation = 'subtasks';
        for ($i = 1; $i < $depth; $i++) {
            $relation .= '.subtasks';
        }
        return $relation;
    }
    public function edit($id){
        $task = Task::findOrFail($id);
        
        $PmStatus = PmStatus::all();

        $projects = Project::all();

        $users = Taskusers::select('task_users.*', 'users.name', 'users.email')
                                            ->join('users', 'users.id', 'task_users.user_id')
                                            ->where('task_users.task_id', $task->id)
                                            ->get();

        $potentialParents = Task::select('tasks.*', 'projects.project_designation')
                                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                                ->where('tasks.id', '!=', $id)
                                ->get();

        return view('tasks.edit', ['task' => $task, 'PmStatus' => $PmStatus, 'projects'=>$projects, 'users' => $users, 'potentialParents' => $potentialParents]);
    }

    public function delete($id){
        $task = Task::findOrFail($id);
        
        $task->delete();
        return redirect()->route('tasks.list');
    }
    public function view($id){
        $task = Task::findOrFail($id);
        $project = Project::findOrFail($task->project_id);

        $users = Taskusers::select('task_users.*', 'users.name', 'users.email')
                                            ->join('users', 'users.id', 'task_users.user_id')
                                            ->where('task_users.task_id', $task->id)
                                            ->get();

        // Load subtasks
        $subtasks = Task::where('parent_task_id', $id)->get();

        // Load dependencies
        $dependencies = $task->dependencies;
        $dependents = $task->dependents;

        // Load required trainings
        $requiredTrainings = $task->requiredTrainings;

        // Check if trainings and dependencies are complete
        $trainingsComplete = $task->areRequiredTrainingsComplete();
        $dependenciesComplete = $task->areDependenciesComplete();

        return view('tasks.view', [
            'task' => $task,
            'project' => $project,
            'users' => $users,
            'subtasks' => $subtasks,
            'dependencies' => $dependencies,
            'dependents' => $dependents,
            'requiredTrainings' => $requiredTrainings,
            'trainingsComplete' => $trainingsComplete,
            'dependenciesComplete' => $dependenciesComplete
        ]);
    }
    public function create(){
        $PmStatus = PmStatus::where('status_stage','inicial')
                            ->where('status_destination','geral')
                            ->orWhere('status_destination','projetos')
                            ->get();

        $projects = Project::whereIn('id', function($query) {
            $query->select('project_id')
                ->from('teams_projects')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id());
                });
        })->get();

        $users = Users::whereIn('id', function($query) {
            $query->select('user_id')
                ->from('teams_users')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id());
                });
        })->get();

        // Get all tasks for potential parent selection (team-filtered)
        $potentialParents = Task::select('tasks.*', 'projects.project_designation')
                                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                                ->whereIn('projects.id', function($query) {
                                    $query->select('project_id')
                                        ->from('teams_projects')
                                        ->whereIn('team_id', function($subQuery) {
                                            $subQuery->select('team_id')
                                                ->from('teams_users')
                                                ->where('user_id', Auth::id());
                                        });
                                })
                                ->get();

        // Get trainings from user's teams
        $trainings = \App\Models\Trainings::whereIn('id', function($query) {
            $query->select('training_id')
                ->from('training_teams')
                ->whereNull('training_teams.deleted_at')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id())
                        ->whereNull('teams_users.deleted_at');
                });
        })->get();

        return view('tasks.create', [
            'projects' => $projects,
            'PmStatus' => $PmStatus,
            'users' => $users,
            'potentialParents' => $potentialParents,
            'trainings' => $trainings
        ]);
    }
    public function update(Request $request, $id){
        $task = Task::findOrFail($id);

        // Check if status is changing
        $statusChanging = $request->inputTaskStatus && $request->inputTaskStatus != $task->task_status;

        if ($statusChanging) {
            // Validate training requirements
            if (!$task->areRequiredTrainingsComplete($request->inputTaskStatus)) {
                return redirect()->back()->withErrors([
                    'status' => 'Não é possível alterar o estado. Os utilizadores atribuídos não completaram as formações obrigatórias.'
                ]);
            }

            // Validate dependencies
            if (!$task->areDependenciesComplete()) {
                return redirect()->back()->withErrors([
                    'status' => 'Não é possível alterar o estado. Esta tarefa depende de outras tarefas ainda não concluídas.'
                ]);
            }
        }

        if($request->inputTaskDesignation != null){
            $task->task_designation = $request->inputTaskDesignation;
        }
        if($request->inputTaskStatus != null){
            $task->task_status = $request->inputTaskStatus;
        }
        if($request->inputTaskDescription != null){
            $task->description = $request->inputTaskDescription;
        }
        if($request->inputTaskProjectId != null){
            $task->project_id = $request->inputTaskProjectId;
        }

        // Update parent task
        if($request->has('inputParentTaskId')){
            $task->parent_task_id = $request->inputParentTaskId ?: null;
        }

        // Update completion percentage
        $task->completion_percentage = $task->calculateCompletionPercentage();

        $task->save();

        // Update parent task status
        $task->updateParentStatus();

        return redirect()->route('tasks.view', ['id' => $task->id]);
    }   
    public function store(request $request){
        $tasks = Task::all();
        $totalTasks = count($tasks);
        $task = new Task();
        $task->task_code = $request->inputTaskAcronomico.'-'.$totalTasks+1;
        $task->task_designation = $request->inputTaskDesignation;
        $task->task_status = $request->inputTaskStatus;
        $task->description = $request->inputTaskDescription;
        $task->project_id = $request->inputTaskProjectId;

        // Set parent task if provided
        if($request->inputParentTaskId != null && $request->inputParentTaskId != ''){
            $task->parent_task_id = $request->inputParentTaskId;
        }

        $task->save();

        // Assign users to task
        if($request->inputTaskUsers != null){
            foreach($request->inputTaskUsers as $user_id){
                $taskUser = new Taskusers();
                $taskUser->task_id = $task->id;
                $taskUser->user_id = $user_id;
                $taskUser->save();
            }
        }

        // Assign required trainings to task
        if($request->inputTaskTrainings != null){
            foreach($request->inputTaskTrainings as $training_id){
                $taskTraining = new \App\Models\TaskTrainings();
                $taskTraining->task_id = $task->id;
                $taskTraining->training_id = $training_id;
                $taskTraining->save();
            }
        }

        return redirect()->route('tasks.view', ['id' => $task->id]);
    }

    public function listByProject($project_id){
        $tasks= Task::where('tasks.project_id', '=', $project_id)
            ->select('tasks.*', 'projects.project_designation')
            ->join('projects', 'tasks.project_id', 'projects.id')
            ->whereIn('projects.id', function($query) {
                $query->select('project_id')
                    ->from('teams_projects')
                    ->whereIn('team_id', function($subQuery) {
                        $subQuery->select('team_id')
                            ->from('teams_users')
                            ->where('user_id', Auth::id());
                    });
            })
            ->get();


        return view('tasks.listByProject', ['tasks' => $tasks]);
    }
}
