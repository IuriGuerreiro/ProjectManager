<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainings;
use App\Models\PmStatus;
use App\Models\Users;
use App\Models\TrainingUsers;
use App\Models\TrainingFormers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TrainingsController extends Controller
{
    use SoftDeletes;

    public function list(){
        $trainings = Trainings::all();

        $data = [];
        
        foreach($trainings as $training){
            $participants = TrainingUsers::where('train_id', $training->id)->get();
            


            $row = [
                "id" => $training->id,
                "trainings_code" => $training->trainings_code,
                "trainings_designation" => $training->trainings_designation,
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

        return view('trainings.create',['PmStatus' => $PmStatus, 'users' => $users]);
    }

    public function store(Request $request){
        $trainings = Trainings::all();
        $training = new Trainings();

        $totalTrainings = count($trainings);
        $training->trainings_code =  $totalTrainings."-".$request->inputTrainingCode;
        $training->trainings_designation = $request->inputTrainingDesignation;
        $training->status = $request->inputTrainingStatus; 

        $training->save();
        if ($request->inputTrainingFormer != null && $request->inputTrainingFormer != "") {
            foreach ($request->inputTrainingFormer as $former) {
                $trainingFormer = new TrainingFormers();
                $trainingFormer->train_id = $training->id;
                $trainingFormer->former_id = $former;
                $trainingFormer->save();  // Save the instance to the database
            }
        }

        return redirect()->route('trainings.list');
    }

    public function view($id){
        
        $training = Trainings::findOrFail($id);

        $users = TrainingUsers::select('trainings_users.*', 'users.name', 'users.email')
                            ->join('users', 'users.id', '=', 'trainings_users.users_id')
                            ->where('trainings_users.train_id', $id)
                            ->get();
        
        $formers = TrainingFormers::select('training_formers.*', 'formers.name', 'formers.email')
                            ->join('formers', 'formers.id', '=', 'training_formers.former_id')
                            ->where('training_formers.train_id', $id)
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

        $users = TrainingUsers::select('trainings_users.*', 'users.name', 'users.email')
                            ->join('users', 'users.id', '=', 'trainings_users.users_id')
                            ->where('trainings_users.train_id', $id)
                            ->get();
        
        $formers = TrainingFormers::select('training_formers.*', 'formers.name', 'formers.email')
                            ->join('formers', 'formers.id', '=', 'training_formers.former_id')
                            ->where('training_formers.train_id', $id)
                            ->get();

        return view('trainings.edit', ['training' => $training, 'users' => $users, 'formers' => $formers]);
    }
}
