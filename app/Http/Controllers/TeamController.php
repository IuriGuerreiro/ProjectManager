<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\Teams_users;
use App\Models\Teams_projects;
use App\Models\Users;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamController extends Controller
{
    use SoftDeletes;

    public function index(){    
        $teams = Teams::all();

        return view('teams.index', ['teams' => $teams]);
    }

    public function create(){

        $users = Users::all();
        
        return view('teams.create', ['users' => $users]);
    }

    public function store(Request $request){
        $team = new Teams();

        $team->team_designation = $request->inputTeamDesignation;
        $team->team_function = $request->inputTeamfunction; 

        $team->save();

        return redirect()->route('teams.list');
    }

    public function view($id){
        
        $team = Teams::findOrFail($id);

        $users = Teams_users::select('teams_users.*', 'users.name as user_name', 'users.email as user_email')
                            ->join('users', 'users.id', '=', 'teams_users.user_id')
                            ->where('teams_users.team_id', $id)
                            ->get();

        $projects = Teams_projects::select('teams_projects.*', 'projects.project_designation', 'projects.description as project_description', 'projects.project_status')
                                  ->join('projects', 'projects.id', '=', 'teams_projects.project_id')
                                  ->where('teams_projects.team_id', $id)->get();

        return view('teams.view', ['team' => $team, 'users' => $users, 'projects' => $projects]);
    }

    public function edit($id){
        
        $team = Teams::findOrFail($id);

        $users = Teams_users::select('teams_users.*', 'users.name as user_name', 'users.email as user_email')
                            ->join('users', 'users.id', '=', 'teams_users.user_id')
                            ->where('teams_users.team_id', $id)
                            ->get();

        $projects = Teams_projects::select('teams_projects.*', 'projects.project_designation', 'projects.description as project_description', 'projects.project_status')
                                  ->join('projects', 'projects.id', '=', 'teams_projects.project_id')
                                  ->where('teams_projects.team_id', $id)->get();

        return view('teams.edit', ['team' => $team, 'users' => $users, 'projects' => $projects]);
    }

    public function update($id, Request  $request ){
        $team = Teams::findOrFail($id);

        if ($request->inputTeamDesignation != null)
            $team->team_designation = $request->inputTeamDesignation;
        if($request->inputTeamfunction != null)
            $team->team_function = $request->inputTeamfunction;

        $team->save();
        return redirect()->route('teams.view', ['team_id' => $team->id]);
    }

    public function AddUser($id){

        $team = Teams::findOrFail($id);

        $users = Users::wherenotIn('users.id', function($query) use ($id){
                        $query->select('team_id')
                            ->from('teams_users')
                            ->where('teams_users.team_id', $id);
                        })
                        ->get();

        return view('teams.addUser', ['team' => $team, 'users' => $users]);
    }
    public function storeUser($id, Request $request){

        $team = Teams::findOrFail($id);

        $user= Users::findOrFail($request->inputUserId);

        
        if($team != null || $user != null){
            $Teams_users = new Teams_users();
            $Teams_users->team_id = $team->id;
            $Teams_users->user_id = $user->id;
            $Teams_users->save();
        }
        

        return redirect()->route('teams.view', ['team_id' => $team->id]);
    }

    public function removerUser($id){
        $team_user = Teams_users::findOrFail($id);
        $team_user->delete();
        
        return redirect()->route('teams.list');
    }
}
