<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teams;
use App\Models\Teams_users;
use App\Models\Teams_projects;
use App\Models\Users;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    use SoftDeletes;

    public function index(){
        // Only show teams where the current user is a member
        $teams = Teams::whereIn('id', function($query) {
            $query->select('team_id')
                ->from('teams_users')
                ->where('user_id', Auth::id());
        })
        ->withCount('users as members_count')
        ->get();

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

        // Automatically add the creator to the team
        Teams_users::create([
            'team_id' => $team->id,
            'user_id' => Auth::id(),
        ]);

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

    public function showInvite($token)
    {
        $team = Teams::where('invite_token', $token)->firstOrFail();

        // Check if invite is expired
        if ($team->isInviteExpired()) {
            return view('teams.invite-expired', compact('team'));
        }

        // Check if user is already a member
        $isMember = Teams_users::where('team_id', $team->id)
            ->where('user_id', Auth::id())
            ->exists();

        return view('teams.invite', compact('team', 'isMember'));
    }

    public function joinViaInvite($token)
    {
        $team = Teams::where('invite_token', $token)->firstOrFail();

        // Check if invite is expired
        if ($team->isInviteExpired()) {
            return redirect()->route('teams.list')
                ->with('error', 'Este convite expirou.');
        }

        // Check if user is already a member
        $exists = Teams_users::where('team_id', $team->id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$exists) {
            Teams_users::create([
                'team_id' => $team->id,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('teams.view', ['team_id' => $team->id])
                ->with('success', 'Juntou-se à equipa com sucesso!');
        }

        return redirect()->route('teams.view', ['team_id' => $team->id])
            ->with('info', 'Já é membro desta equipa.');
    }

    public function regenerateInviteToken($id)
    {
        $team = Teams::findOrFail($id);
        $team->regenerateInviteToken();

        return redirect()->route('teams.view', ['team_id' => $team->id])
            ->with('success', 'Link de convite regenerado com sucesso!');
    }
}
