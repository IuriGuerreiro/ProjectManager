<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainings;
use App\Models\TrainingUsers;
use App\Models\Users;

class TrainingUserscontroller extends Controller
{
    public function addUsers($id){
        $training = Trainings::findOrFail($id);
   
        $users = Users::Select('users.*')
                        ->whereNotIn('users.id', function($query) use ($id){
                            $query->select('users.id')
                                ->from('users')
                                ->join('training_users', 'users.id', '=', 'training_users.users_id')
                                ->where('training_users.train_id', $id);
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
