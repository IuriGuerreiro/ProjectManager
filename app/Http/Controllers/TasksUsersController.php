<?php

namespace App\Http\Controllers;
use App\Models\users;
use App\Models\Task;
use App\Models\Taskusers;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasksUsersController extends Controller
{
    use SoftDeletes;

    public function remove($id){
        $Task = Taskusers::findOrFail($id);
        $Task->delete();
    
        return redirect()->route('users.list');
    }

    public function AddToTask($id){
        $task = Task::findOrFail($id);
        
        $users = users::select('users.*')
                        ->join('teams_users', 'users.id', '=', 'teams_users.user_id')
                        ->join('teams_projects','teams_users.team_id', '=', 'teams_projects.team_id')
                        ->where('teams_projects.project_id', $task->project_id)
                        ->whereNotIn('users.id', function($query) use ($id){
                        $query->select('user_id')
                            ->from('task_users')
                            ->where('task_id', $id);
                        })
                        ->get();
    
        $users = $users->unique('users.id');

        return view('tasks.addTaskToUser', ['task' => $task, 'users' => $users]);
    }

    public function store($task_id, request $request){
        $task = Task::findOrFail($task_id);
        $user = users::findOrFail($request->input('inputTaskuserId'));
        if($task != null || $users != null){
            $taskUser = new TaskUsers();
            $taskUser->task_id = $task->id;
            $taskUser->user_id = $user->id;
            $taskUser->save();
        }
        return redirect()->route('users.view', ['id' => $user->id]);
    }

}
