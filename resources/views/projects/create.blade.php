@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    criar projeto
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data"class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectDesignation">
                                    Designação do projeto
                                </label>
                                <input class="form-control" type="text" id="inputProjectDesignation"name="inputProjectDesignation" placeholder="Designação do projeto" value="{{old('inputProjectDesignation')}}" REQUIRED autocomplete="off">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectAcronimo">
                                    Acrónimo do projeto
                                </label>
                                <input class="form-control" type="text" id="inputProjectAcronimo"name="inputProjectAcronimo" placeholder="Acrónimo do projeto" value="{{old('inputProjectAcronimo')}}" REQUIRED autocomplete="off">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectStatus" > estado do projeto</label>
                                <select class="form-control" name="inputProjectStatus" id="inputProjectStatus" >
                                    @foreach($PmStatus as $status)  
                                        <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectTeam[]"> Users for training</label>
                                <div class="form-control">
                                    @foreach($teams as $team)
                                        <input type="checkbox" name="inputProjectTeam[]" id="inputProjectTeam[]" value="{{ $team->id }} "> {{ $team->team_code }} - {{ $team->team_designation }}
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectDescription">descrição do projeto</label>
                                <textarea class="form-control" name="inputProjectDescription" id="inputProjectDescription" cols="30" rows="10" autocomplete="off"></textarea>
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