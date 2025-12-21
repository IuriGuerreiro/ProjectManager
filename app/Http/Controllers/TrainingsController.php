<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainings;
use App\Models\PmStatus;
use App\Models\Users;
use App\Models\TrainingUsers;
use App\Models\TrainingFormers;
use App\Models\TrainingTeams;
use App\Models\Teams;
use App\Models\Formers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TrainingsController extends Controller
{
    use SoftDeletes;

    public function list(){
        // Only show trainings for teams the user is in
        $trainings = Trainings::whereIn('id', function($query) {
            $query->select('training_id')
                ->from('training_teams')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id());
                });
        })->get();

        $data = [];

        foreach($trainings as $training){
            $participants = TrainingUsers::where('train_id', $training->id)->get();

            $row = [
                "id" => $training->id,
                "trainings_code" => $training->trainings_code,
                "trainings_designation" => $training->trainings_designation,
                "description" => $training->description,
                "status" => $training->status,
                "participants" => count($participants)
            ];

            $data[] = $row;
        }

        return view('trainings.index', ['trainings' => $data]);
    }

    public function create(){

        $PmStatus = PmStatus::where('status_stage','inicial')
                            ->where('status_destination','geral')
                            ->orWhere('status_destination','trainings')
                            ->orWhere('status_destination','formações')
                            ->orWhere('status_destination','formação')
                            ->get();

        $users = Users::whereIn('id', function($query) {
            $query->select('user_id')
                ->from('teams_users')
                ->whereIn('team_id', function($subQuery) {
                    $subQuery->select('team_id')
                        ->from('teams_users')
                        ->where('user_id', Auth::id());
                });
        })->get();

        // Get formers from user's teams only
        $formers = Formers::whereIn('id', function($query) {
            $query->select('former_id')
                ->from('former_teams')
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

        return view('trainings.create',[
            'PmStatus' => $PmStatus,
            'users' => $users,
            'formers' => $formers,
            'teams' => $teams
        ]);
    }

    public function store(Request $request){
        $trainings = Trainings::all();
        $training = new Trainings();

        $totalTrainings = count($trainings);
        $training->trainings_code =  $totalTrainings."-".$request->inputTrainingCode;
        $training->trainings_designation = $request->inputTrainingDesignation;
        $training->description = $request->inputTrainingDescription;
        $training->status = $request->inputTrainingStatus;
        $training->created_by = Auth::id();

        $training->save();

        // Assign formers
        if ($request->inputTrainingFormer != null && $request->inputTrainingFormer != "") {
            foreach ($request->inputTrainingFormer as $former) {
                $trainingFormer = new TrainingFormers();
                $trainingFormer->train_id = $training->id;
                $trainingFormer->former_id = $former;
                $trainingFormer->save();
            }
        }

        // Assign teams
        if ($request->inputTrainingTeams != null && is_array($request->inputTrainingTeams)) {
            foreach ($request->inputTrainingTeams as $team_id) {
                $trainingTeam = new TrainingTeams();
                $trainingTeam->training_id = $training->id;
                $trainingTeam->team_id = $team_id;
                $trainingTeam->save();
            }
        }

        // Assign users
        if ($request->inputTrainingUser != null && is_array($request->inputTrainingUser)) {
            foreach ($request->inputTrainingUser as $user_id) {
                $trainingUser = new TrainingUsers();
                $trainingUser->train_id = $training->id;
                $trainingUser->users_id = $user_id;
                $trainingUser->save();
            }
        }

        return redirect()->route('trainings.list');
    }

    public function view($id){

        $training = Trainings::findOrFail($id);

        $users = TrainingUsers::select('trainings_users.*', 'users.name', 'users.email')
                            ->join('users', 'users.id', '=', 'trainings_users.users_id')
                            ->where('trainings_users.train_id', $id)
                            ->whereNull('users.deleted_at')
                            ->get();

        $formers = TrainingFormers::select('training_formers.*', 'formers.name', 'formers.email')
                            ->join('formers', 'formers.id', '=', 'training_formers.former_id')
                            ->where('training_formers.train_id', $id)
                            ->whereNull('formers.deleted_at')
                            ->get();

        return view('trainings.view', ['training' => $training, 'users' => $users, 'formers' => $formers]);
    }

    public function delete($id){
        
        $training = Trainings::findOrFail($id);
        $training->delete();

        return redirect()->route('trainings.list');
    }

    public function edit($id){
        $training = Trainings::findOrFail($id);

        $PmStatus = PmStatus::all();

        $users = TrainingUsers::select('trainings_users.*', 'users.name', 'users.email')
                            ->join('users', 'users.id', '=', 'trainings_users.users_id')
                            ->where('trainings_users.train_id', $id)
                            ->whereNull('users.deleted_at')
                            ->get();

        $formers = TrainingFormers::select('training_formers.*', 'formers.name', 'formers.email')
                            ->join('formers', 'formers.id', '=', 'training_formers.former_id')
                            ->where('training_formers.train_id', $id)
                            ->whereNull('formers.deleted_at')
                            ->get();

        // Get all available formers from user's teams
        $availableFormers = Formers::whereIn('id', function($query) {
            $query->select('former_id')
                ->from('former_teams')
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

        // Get currently assigned teams
        $assignedTeams = $training->teams->pluck('id')->toArray();

        return view('trainings.edit', [
            'training' => $training,
            'users' => $users,
            'formers' => $formers,
            'availableFormers' => $availableFormers,
            'teams' => $teams,
            'assignedTeams' => $assignedTeams,
            'PmStatus' => $PmStatus
        ]);
    }

    public function update(Request $request, $id){
        $training = Trainings::findOrFail($id);

        $training->trainings_designation = $request->inputTrainingDesignation;
        $training->description = $request->inputTrainingDescription;
        $training->status = $request->inputTrainingStatus;
        $training->save();

        // Update team assignments - remove old and add new
        TrainingTeams::where('training_id', $id)->delete();
        if ($request->inputTrainingTeams != null && is_array($request->inputTrainingTeams)) {
            foreach ($request->inputTrainingTeams as $team_id) {
                $trainingTeam = new TrainingTeams();
                $trainingTeam->training_id = $training->id;
                $trainingTeam->team_id = $team_id;
                $trainingTeam->save();
            }
        }

        return redirect()->route('trainings.view', ['training_id' => $id]);
    }
}
