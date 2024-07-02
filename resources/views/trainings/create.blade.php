@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    criar formação
                </div>
                <div class="card-body">
                    <form action="{{ route('trainings.store') }}" method="POST" enctype="multipart/form-data"class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="inputTrainingDesignation">
                                    Designação da formação
                                </label>
                                <input class="form-control" type="text" id="inputTrainingDesignation"name="inputTrainingDesignation" placeholder="Designação da formação" value="{{old('inputProjectDesignation')}}" REQUIRED autocomplete="off">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputTrainingCode">
                                    Acrónimo da formação
                                </label>
                                <input class="form-control" type="text" id="inputTrainingCode"name="inputTrainingCode" placeholder="Acrónimo da formação" value="{{old('inputProjectAcronimo')}}" REQUIRED autocomplete="off">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputTrainingStatus" > estado da formação</label>
                                <select class="form-control" name="inputTrainingStatus" id="inputTrainingStatus" >
                                    @foreach($PmStatus as $status)
                                        <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="inputTrainingUser[]"> Users for training</label>
                                <div class="form-control">
                                    @foreach($users as $user)
                                        <input type="checkbox" name="inputTrainingUser[]" id="inputTrainingUser[]" value="{{ $user->id }} "> {{ $user->name }}
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">Registrar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('projects.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection