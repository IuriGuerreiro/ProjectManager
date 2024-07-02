<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\PmStatus;
use App\Models\Teams;
use App\Models\Teams_Projects;
use App\Models\TasksUsers;
use App\Models\Task;


class ProjectController extends Controller
{
    use SoftDeletes;

    public function index(){
        $projects = Project::all();

        return view('projects.index', ['projects' => $projects]);
    }


    public function edit($id){

        $project = Project::findOrFail($id);

        $PmStatus = PmStatus::where('status_stage','inicial')
                            ->where('status_destination','geral')
                            ->orWhere('status_destination','projetos')
                            ->get();

        $teams = Teams_Projects::select('Teams_Projects.*', 'teams.team_designation', 'teams.team_function')

                                ->join('teams', 'teams.id', 'Teams_Projects.team_id')

                                ->where('Teams_Projects.project_id', $id)

                                ->get();

        $tasks = Task::where('project_id', $id)->get();

        return view('projects.edit', ['project' => $project, 'PmStatus' => $PmStatus, 'teams' => $teams, 'tasks' => $tasks]);
    }


    public function view($id){
        $project = Project::findOrFail($id);
        $teams = Teams_Projects::select('Teams_Projects.*', 'teams.team_designation', 'teams.team_function')

                                ->join('teams', 'teams.id', 'Teams_Projects.team_id')

                                ->where('Teams_Projects.project_id', $id)

                                ->get();

        $tasks = Task::where('project_id', $id)->get();
        
        return view('projects.view', ['project' => $project, 'teams' => $teams, 'tasks' => $tasks]);
    }


    public function delete($id){
        $projects = Project::findOrFail($id);

        $projects->delete();

        
        return redirect()->route('projects.list');
    }


    public function create(){
        $PmStatus = PmStatus::where('status_stage','inicial')
                            ->where('status_destination','geral')
                            ->orWhere('status_destination','projetos')
                            ->get();

        $teams = Teams::all();

        return view('projects.create', ['PmStatus' => $PmStatus, 'teams' => $teams]);
    }


    public function store(Request $request){
        $project = new Project();

        $projects = Project::all();
        $totalProjects = count($projects);
        $project->project_code = $request->inputProjectAcronimo.'-'.$totalProjects+1;
        $project->project_designation = $request->inputProjectDesignation;
        $project->project_status = $request->inputProjectStatus;
        $project->description = $request->inputProjectDescription;

        $project->save();
        if($request->inputProjectTeam != null){
            foreach ($request->inputProjectTeam as $team) {
                $teamProject = new Teams_Projects();
                $teamProject->team_id = $team;
                $teamProject->project_id = $project->id;
                $teamProject->save();
            }
        }

        return redirect()->route('projects.view', ['id'=>$project->id]);
    }


    public function update(Request $request, $id){
        $project = Project::findOrFail($id);
        if($request->inputProjectDesignation != null){
            $project->project_designation = $request->inputProjectDesignation;
        }
        if($request->inputProjectStatus != null){
            $project->project_status = $request->inputProjectStatus;
        }
        if($request->inputProjectDescription != null){
            $project->description = $request->inputProjectDescription;
        }
        $project->save();

        return redirect()->route('projects.view', ['id'=>$project->id]);
    }
}
