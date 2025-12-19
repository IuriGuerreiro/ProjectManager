<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\PmStatus;
use App\Models\Taskusers;


use Illuminate\Database\Eloquent\SoftDeletes;

class TaskController extends Controller
{

    use SoftDeletes;

    public function index(){
        $tasks = Task::select('tasks.*', 'projects.project_designation')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->get();
    
        return view('tasks.index', ['tasks' => $tasks]);
    }
    public function edit($id){
        $task = Task::findOrFail($id);
        
        $PmStatus = PmStatus::all();

        $projects = Project::all();

        $users = Taskusers::select('task_users.*', 'users.name', 'users.email')
                                            ->join('users', 'users.id', 'task_users.user_id')
                                            ->where('task_users.task_id', $task->id)
                                            ->get();

        return view('tasks.edit', ['task' => $task, 'PmStatus' => $PmStatus, 'projects'=>$projects, 'users' => $users]);
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

        return view('tasks.view', ['task' => $task, 'project' => $project, 'users' => $users]);
    }
    public function create(){
        $PmStatus = PmStatus::where('status_stage','inicial')
                            ->where('status_destination','geral')
                            ->orWhere('status_destination','projetos')
                            ->get();

        $projects = Project::all();
        $users = Users::all();

        return view('tasks.create', ['projects' => $projects, 'PmStatus' => $PmStatus, 'users' => $users]);
    }
    public function update(Request $request, $id){
        $task = Task::findOrFail($id);
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
        $task->save();

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
        $task->save();

        if($request->inputTaskUsers != null){
            foreach($request->inputTaskUsers as $user_id){
                $taskUser = new Taskusers();
                $taskUser->task_id = $task->id;
                $taskUser->user_id = $user_id;
                $taskUser->save();
            }
        }

        return redirect()->route('tasks.view', ['id' => $task->id]); 
    }

    public function listByProject($project_id){
        $tasks= Task::where('tasks.project_id', '=', $project_id)
            ->select('tasks.*', 'projects.project_designation')
            ->join('projects', 'tasks.project_id', 'projects.id')
            ->get();


        return view('tasks.listByProject', ['tasks' => $tasks]);
    }
}
