<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formers;
use App\Models\Trainings;
use App\Models\TrainingFormers;

class FormersController extends Controller
{
    public function list(){
        $formers = Formers::all();
        
        return view('formers.index', ['formers' => $formers]);
    }
    public function create(){
        $trainings = Trainings::all();

        return view('formers.create', ['trainings' => $trainings]);
    }
    public function store(request $request){

        $former = new Formers();
        $former->name = $request->input('inputFormerName');
        $former->email = $request->input('inputFormerEmail');
        $former->save();

        if ($request->input('inputFormerTrainings') != null) {
            foreach ($request->input('inputFormerTrainings') as $training_id) {
                $formerTraining = new TrainingFormers();
                $formerTraining->former_id = $former->id;
                $formerTraining->train_id = $training_id;
                $formerTraining->save();
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
