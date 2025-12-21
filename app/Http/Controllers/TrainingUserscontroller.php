<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainings;
use App\Models\TrainingUsers;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class TrainingUserscontroller extends Controller
{
    public function addUsers($id){
        $training = Trainings::findOrFail($id);
   
        $users = Users::whereIn('id', function($query) use ($id) {
                        $query->select('user_id')
                            ->from('teams_users')
                            ->whereNull('teams_users.deleted_at')
                            ->whereIn('team_id', function($subQuery) use ($id) {
                                $subQuery->select('team_id')
                                    ->from('training_teams')
                                    ->where('training_id', $id)
                                    ->whereNull('training_teams.deleted_at');
                            });
                        })
                        ->whereNotIn('id', function($query) use ($id){
                            $query->select('users_id')
                                ->from('trainings_users')
                                ->where('train_id', $id)
                                ->whereNotNull('users_id')
                                ->whereNull('trainings_users.deleted_at');
                        })
                        ->get();


        return view('trainings.addUsers', ['training' => $training, 'users' => $users]);
    }

    public function storeUsers($id, Request $request){
        $training = Trainings::findOrFail($id);

        if($request->inputTrainingUser != null || $request->inputTrainingUser != null){
            foreach($request->inputTrainingUser as $user){
                $trainingUser = new TrainingUsers();
                $trainingUser->train_id = $training->id;
                $trainingUser->users_id = $user;
                $trainingUser->save();
            }
        }

        return redirect()->route('trainings.list');
    }
}
