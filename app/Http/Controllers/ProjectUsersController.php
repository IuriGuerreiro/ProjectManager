<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\Project;
use App\Models\Projectsusers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUsersController extends Controller
{
    use SoftDeletes;

    public function remove($id){
        $project = Projectsusers::findOrFail($id);
        $project->delete();
        
        return redirect()->route('users.list');
    }


    public function store($project_id, request $request){
        $project = Project::findOrFail($project_id);
        $user = Users::findOrFail($request->input('inputuserId'));
        
        
        if($project != null || $user != null){
            $projectuser = new Projectsusers();
            $projectuser->project_id = $project->id;
            $projectuser->user_id = $user->id;
            $projectuser->save();
        }

        return redirect()->route('users.view', ['id' => $user->id]);
    }


    public function AddProjectTouser($id){
        $project = Project::findOrFail($id);
        $users = Users::whereNotIn('users.id', function($query) use ($id){
                        $query->select('user_id')
                            ->from('project_users')
                            ->where('project_id', $id);
                        })
                        ->get();
        return view('users.addProjectTouser', ['project' => $project, 'users' => $users]);
    }


    public function AdduserToProject($id){
        $user = Users::where('users.id', $id)
                    ->first();

        $projects = Project::whereNotIn('projects.id', function($query) use ($id){
                                $query->select('project_id')
                                ->from('project_users')
                                ->where('user_id', $id);
                            })
                            ->get();

        return view('users.adduserToProject', ['projects' => $projects, 'user' => $user]);
    }

    public function storeuserToProject($user_id, request $request){
        $user = Users::findOrFail($user_id);
        $project_id = $request->inputProjectId;
        $project = Project::findOrFail($project_id);
        
        
        if($project->id != null || $user->id != null){
            $projectuser = new Projectsusers();
            $projectuser->project_id = $project->id;
            $projectuser->user_id = $user->id;
            $projectuser->save();
        }
        return redirect()->route('users.view', ['id' => $user->id]);
    }
}
