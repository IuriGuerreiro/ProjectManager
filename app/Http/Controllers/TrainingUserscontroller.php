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
   
        $users = Users::whereIn('id', function($query) {
                        $query->select('user_id')
                            ->from('teams_users')
                            ->whereIn('team_id', function($subQuery) {
                                $subQuery->select('team_id')
                                    ->from('teams_users')
                                    ->where('user_id', Auth::id());
                            });
                        })
                        ->whereNotIn('id', function($query) use ($id){
                            $query->select('users_id')
                                ->from('training_users')
                                ->where('train_id', $id);
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
