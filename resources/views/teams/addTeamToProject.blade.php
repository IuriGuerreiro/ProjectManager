@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Adicionar colaboradores ao projeto
                </div>
                <div class="card-body">
                    <form action="{{Route('teams.storeTeamToProject', ['user_id' => $team->id])}}" method="POST" enctype="multipart/form-data" class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectDesignation">
                                    nome do colaborador
                                </label>
                                <span class="form-control">{{ $team->team_designation }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectAcronimo">
                                    email do colaborador
                                </label>
                                <span class="form-control">{{ $team->email }}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputProjectId">
                                    projeto para adicionar
                                </label>
                                <select class="form-control" name="inputProjectId" id="inputProjectId">
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->project_designation }}- {{ $project->project_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">adiconar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('teams.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection