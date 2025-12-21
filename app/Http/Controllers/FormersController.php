<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formers;
use App\Models\Trainings;
use App\Models\TrainingFormers;
use App\Models\FormerTeams;
use App\Models\Teams;
use Illuminate\Support\Facades\Auth;

class FormersController extends Controller
{
    public function list(){
        // Only show formers from user's teams
        $formers = Formers::whereIn('id', function($query) {
            $query->select('former_id')
                ->from('former_teams')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id());
                });
        })->get();

        return view('formers.index', ['formers' => $formers]);
    }
    public function create(){
        // Only show trainings from user's teams
        $trainings = Trainings::whereIn('id', function($query) {
            $query->select('training_id')
                ->from('training_teams')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id());
                });
        })->get();

        // Get user's teams for selection
        $teams = Teams::whereIn('id', function($query) {
            $query->select('team_id')
                ->from('teams_users')
                ->where('user_id', Auth::id());
        })->get();

        return view('formers.create', ['trainings' => $trainings, 'teams' => $teams]);
    }
    public function store(request $request){

        $former = new Formers();
        $former->name = $request->input('inputFormerName');
        $former->email = $request->input('inputFormerEmail');
        $former->save();

        // Assign to trainings
        if ($request->input('inputFormerTrainings') != null) {
            foreach ($request->input('inputFormerTrainings') as $training_id) {
                $formerTraining = new TrainingFormers();
                $formerTraining->former_id = $former->id;
                $formerTraining->train_id = $training_id;
                $formerTraining->save();
            }
        }

        // Assign to teams
        if ($request->input('inputFormerTeams') != null && is_array($request->input('inputFormerTeams'))) {
            foreach ($request->input('inputFormerTeams') as $team_id) {
                $formerTeam = new FormerTeams();
                $formerTeam->former_id = $former->id;
                $formerTeam->team_id = $team_id;
                $formerTeam->save();
            }
        }

        return redirect()->route('formers.list');
    }

    public function edit(){
        $formers = Formers::all();
        
        return view('formers.index', ['formers' => $formers]);
    }

    public function view($id){
        $former = Formers::findOrFail($id);

        $trainings = TrainingFormers::select('training_formers.*', 'trainings.trainings_designation', 'trainings.trainings_code')
                                    ->join('trainings', 'trainings.id', 'training_formers.train_id')
                                    ->where('training_formers.former_id', $id)
                                    ->get();
        
        return view('formers.view', ['former' => $former, 'trainings' => $trainings]);
    }

    public function delete(){
        $formers = Formers::all();
        
        return view('formers.index', ['formers' => $formers]);
    }
}
