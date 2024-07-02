@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Ver projeto
                    <span class="float-end">
                        <a href="{{ Route('teams.edit', ['team_id'=>$team->id]) }}" class="text-sucess ml-auto"><i class="fa-solid fa-edit"></i></a>
                    </span>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label for="inputProjectStatus">estado</label>
                                <span class="form-control">{{ $team->team_designation }}</span>
                            </div>
                            <div class="col-md-6 mb-6">
                                <label for="inputProjectDescription">descrição do projeto</label>
                                <span class="form-control">{{ $team->team_function }}</span>
                            </div>
                            <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver utilizadores da equipa
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
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
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
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
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('projects.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection