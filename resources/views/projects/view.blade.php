@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Ver projeto
                    <span class="float-end">
                        <a href="{{ Route('projects.edit', ['id' => $project->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-edit"></i></a>
                    </span>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectDesignation">
                                    codigo do projeto
                                </label>
                                <span class="form-control">{{ $project->project_code }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectStatus">Designação</label>
                                <span class="form-control">{{ $project->project_designation }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectStatus">estado</label>
                                <span class="form-control">{{ $project->project_status }}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputProjectDescription">descrição do projeto</label>
                                <hr class="mt-0">
                                {{ $project->description }}
                            </div>



                            <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver equipas do projeto
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            @Lang('designação da equipa')
                                                        </th>
                                                        <th>
                                                            @Lang('função da equipa')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($teams as $team)
                                                    <tr>
                                                        <td>{{ $team->team_designation ?? '--'}}</td>
                                                        <td>{{ $team->team_function ?? '--'}}</td>
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
                                            Ver tarefas do projeto
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            @Lang('Designação da tarefa')
                                                        </th>
                                                        <th>
                                                            @Lang('Estado da tarefa')
                                                        </th>
                                                        <th>
                                                            @Lang('Descrição da tarefa')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tasks as $task)
                                                    <tr>
                                                        <td>{{ $task->task_designation}}</td>
                                                        <td>{{ $task->task_status}}</td>
                                                        <td>{{ $task->task_description}}</td>
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