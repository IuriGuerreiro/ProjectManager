@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Adicionar colaboradores ao projeto
                </div>
                <div class="card-body">
                    <form action="{{Route('teams.storeProjectToTeam', ['project_id' => $project->id])}}" method="POST" enctype="multipart/form-data" class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectDesignation">
                                    Designação do projeto
                                </label>
                                <span class="form-control">{{ $project->project_designation }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectAcronimo">
                                    Acronimo do projeto
                                </label>
                                <span class="form-control">{{ $project->project_code }}</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="inputProjectTeams[]"> Users for training</label>
                                    <div class="form-control">
                                        @foreach($teams as $team)
                                            <input type="checkbox" name="inputProjectTeams[]" id="inputProjectTeams[]" value="{{ $team->id }} "> {{ $team->team_designation }}
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">adiconar</button>
                        <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('teams.list')}}"><i class="fa-solid fa-arrow-left"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection