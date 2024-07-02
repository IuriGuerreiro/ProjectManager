@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Adicionar utilizadores á formação
                </div>
                <div class="card-body">
                    <form action="{{Route('trainings.storeUsers', ['training_id' => $training->id])}}" method="POST" enctype="multipart/form-data" class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectDesignation">
                                    codigo da formaçao
                                </label>
                                <span class="form-control">{{ $training->trainings_code }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectAcronimo">
                                    designação da formaçao
                                </label>
                                <span class="form-control">{{ $training->trainings_designation }}</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="inputTrainingUser[]"> Users for training</label>
                                    <div class="form-control">
                                        @foreach($users as $user)
                                            <input type="checkbox" name="inputTrainingUser[]" id="inputTrainingUser[]" value="{{ $user->users_id }} "> {{ $user->name }}
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">adiconar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('trainings.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection