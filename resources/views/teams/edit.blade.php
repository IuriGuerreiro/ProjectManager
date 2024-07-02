@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Editar a equipa
                </div>
                <div class="card-body">
                    <form action="{{ Route('teams.update', ['team_id'=>$team->id])}}" method="POST">
                    @csrf 
                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label for="inputTeamDesignation">Designação da equipa</label>
                                    <input class="form-control" id="inputTeamDesignation" name="inputTeamDesignation" placeholder="{{ $team->team_designation }}" >
                                </div>
                                <div class="col-md-6 mb-6">
                                    <label for="inputTeamfunction">Função da equipa</label>
                                    <input class="form-control" id="inputTeamfunction" name="inputTeamfunction" placeholder="{{ $team->team_function }}" >
                                </div>
                                <div class="container">
                                    <div class="mt-5">
                                        <div class="card">
                                            <div class="card-header">
                                                Ver utilizadores da equipa
                                                <span class="float-end">
                                                    <a href="{{ route('teams.AddUser', ['user_id'=>$team->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="actions text-center px-0 sorting_disabled">
                                                                <i class="fas fa-tools text-black"></i>
                                                            </th>
                                                            <th>
                                                                @Lang('name')
                                                            </th>
                                                            <th>
                                                                @Lang('email')
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($users as $user)
                                                        <tr>
                                                            <td>
                                                                <a class="text-info ml-auto" href="{{ Route('users.view', ['id'=>$user->id])}}"><i class="fa-solid fa-eye"></i></a>
                                                                <a class="text-danger ml-auto"href="{{ Route( 'teams.removerUser', ['user_id'=> $user->id] ) }}"><i class="fa-solid fa-trash"></i></a>
                                                            </td>
                                                            <td>{{ $user->user_name ?? '--'}}</td>
                                                            <td>{{ $user->user_email ?? '--'}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="mt-5">
                                        <div class="card">
                                            <div class="card-header">
                                                Ver projetos da equipa
                                                <span class="float-end">
                                                    <a href="{{ route('teams.addTeamToProject', ['team_id'=>$team->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                    <thead class="thead-light">
                                                        <tr>
                                                        <th class="actions text-center px-0 sorting_disabled">
                                                                <i class="fas fa-tools text-black"></i>
                                                            </th>
                                                            <th>
                                                                @Lang('Designação do projeto')
                                                            </th>
                                                            <th>
                                                                @Lang('Estado do projeto')
                                                            </th>
                                                            <th>
                                                                @Lang('Descrição do projeto')
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($projects as $project)
                                                        <tr>
                                                            <td>
                                                                <a class="text-info ml-auto" href="{{ Route('projects.view', ['id'=>$project->id])}}"><i class="fa-solid fa-eye"></i></a>
                                                                <a class="text-danger ml-auto"href="{{ Route( 'teams.removeProject', ['Teams_project_id'=> $project->id] ) }}"><i class="fa-solid fa-trash"></i></a>
                                                            </td>
                                                            <td>{{ $project->project_designation}}</td>
                                                            <td>{{ $project->project_status}}</td>
                                                            <td>{{ $project->project_description}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-end mt-3">Atualizar</button>
                        </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('teams.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection