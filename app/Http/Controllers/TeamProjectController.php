<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projectsteams;
use App\Models\Project;
use App\Models\Teams;
use App\Models\Teams_Users;
use App\Models\Teams_Projects;
use Illuminate\Database\Eloquent\SoftDeletes;


class TeamProjectController extends Controller
{
    use SoftDeletes;

    public function remove($id){
        $project = Teams_Projects::findOrFail($id);
        $project->delete();
        
        return redirect()->route('teams.list');
    }


    public function storeProjectToTeam($project_id, request $request){
        $project = Project::findOrFail($project_id);

        if($project != null || $team != null){
            foreach($request->inputProjectTeams as $team_id){
                $Teams_Projects = new Teams_Projects();
                $Teams_Projects->project_id = $project->id;
                $Teams_Projects->team_id = $team_id;
                $Teams_Projects->save();
            }
        }
        return redirect()->route('projects.list');
    }

    public function AddProjectToTeam($id){

        $project = Project::findOrFail($id);

        $teams = Teams::whereNotIn('teams.id', function($query) use ($id){
                        $query->select('team_id')
                            ->from('teams_projects')
                            ->where('project_id', $id)
                            ->where('deleted_at', null);
                        })
                        ->get();

        $existingTeams = Teams::join('teams_projects', 'teams.id', '=', 'teams_projects.team_id')
                            ->where('teams_projects.project_id', $id)
                            ->where('teams_projects.deleted_at', null)
                            ->select('teams.*', 'teams_projects.id as pivot_id')
                            ->get();


        return view('projects.addProjectToTeam', ['project' => $project, 'teams' => $teams, 'existingTeams' => $existingTeams]);
    }


    public function addTeamToProject($id){
        $team = Teams::findOrFail($id);

        $projects = Project::whereNotIn('projects.id', function($query) use ($id){
                                $query->select('project_id')
                                ->from('teams_projects')
                                ->where('team_id', $id);
                            })
                            ->get();

        return view('teams.addTeamToProject', ['projects' => $projects, 'team' => $team]);
    }

    public function storeTeamToProject($team_id, request $request){
        $team = teams::findOrFail($team_id);
        $project_id = $request->inputProjectId;
        $project = Project::findOrFail($project_id);
        
        
        if($project->id != null || $team->id != null){
            $Teams_Projects = new Teams_Projects();
            $Teams_Projects->project_id = $project->id;
            $Teams_Projects->team_id = $team->id;
            $Teams_Projects->save();
        }
        return redirect()->route('projects.list');
    }
}
