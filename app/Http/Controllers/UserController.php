<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\Project;
use App\Models\Teams_projects;
use App\Models\Task;
use App\Models\Taskusers;
use App\Models\Role;
use App\Models\userRoles;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class userController extends Controller
{

    use SoftDeletes;

    public function index(){
        $users = Users::all();
        
        
        return view('users.index', ['users' => $users]);
    }

    public function create(){
        
        return view('users.create');
    }
    public function store(request $request){

        $user = new Users();
        $user->name = $request->input('inputUserName');
        $user->email = $request->input('inputUserEmail');
        $user->password = $request->input('inputUserPassword');
        $user->save();

        return redirect()->route('users.list');
    }
    public function update(request $request , $id){
        
        
        return view('users.index');
    }

    public function edit($id){
        $user = Users::where('users.id', $id)
                    ->first();
       
        $projects = Teams_projects::select('Teams_projects.*', 'projects.project_designation', 'projects.project_code')
                                ->join('projects', 'projects.id', 'Teams_projects.project_id')
                                ->join('teams_users', 'teams_users.team_id', '=', 'Teams_projects.team_id')
                                ->where('teams_users.user_id', $id)
                                ->get();
        

        // goups the the projects by project_id so there is no more than one project with the same id
        $projects = $projects->unique('project_id');

        $tasks = Taskusers::select('task_users.*', 'tasks.task_designation', 'tasks.task_code')
                                ->join('tasks', 'tasks.id', 'task_users.task_id')
                                ->where('task_users.user_id', $id) 
                                ->get();


        $roles = userRoles::select('user_roles.*', 'roles.role_designation')
                            ->join('roles', 'roles.id', 'user_roles.role_id')
                            ->where('user_roles.user_id', $user->user_id)
                            ->get();

        return view('users.edit', ['users' => $user, 'projects' => $projects, 'tasks'=> $tasks, 'roles' => $roles]);
    }

    // this function is used to view the user, the projects, taks and roles that it has or it belongs to

    public function view($id){

        $user = Users::findOrFail($id);
       
        $projects = Teams_projects::select('Teams_projects.*', 'projects.project_designation', 'projects.project_code')
                                        ->join('projects', 'projects.id', 'Teams_projects.project_id')
                                        ->join('teams_users', 'teams_users.team_id', '=', 'Teams_projects.team_id')
                                        ->where('teams_users.user_id', $id) 
                                        ->get();

        $tasks = Taskusers::select('task_users.*', 'tasks.task_designation', 'tasks.task_code')
                                ->join('tasks', 'tasks.id', 'task_users.task_id')
                                ->where('task_users.user_id', $id) 
                                ->get();

        $roles = userRoles::select('user_roles.*', 'roles.role_designation')
                                ->join('roles', 'roles.id', 'user_roles.role_id')
                                ->where('user_roles.user_id', $user->user_id)
                                ->get();

        return view('users.view', ['users' => $user, 'projects' => $projects, 'tasks'=> $tasks, 'roles' => $roles]);
    }


    public function delete($id){
        $user = Users::findOrFail($id);
        $user->delete(); 

        return redirect()->route('users.list');
    }
}
