@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    editar o projeto
                </div>
                <div class="card-body">
                    <form action="{{Route('projects.update', ['id' => $project->id])}}" method="POST" enctype="multipart/form-data" class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectDesignation">
                                    designação do projeto
                                </label>
                                <input class="form-control" type="text" id="inputProjectDesignation"name="inputProjectDesignation" placeholder="{{ $project->project_designation }}" autocomplete="off"  value="{{old('inputProjectDesignation')}}" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectAcronimo">
                                    acronimo do projeto
                                </label>
                                <span class="form-control">{{ $project->project_code }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputProjectStatus" > estado do projeto</label>
                                <select class="form-control" name="inputProjectStatus" id="inputProjectStatus" >
                                    <option >{{ $project->project_status }}</option>
                                    @foreach($PmStatus as $status)
                                        <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputProjectDescription">descrição do projeto</label>
                                <textarea class="form-control" name="inputProjectDescription" id="inputProjectDescription" cols="30" rows="10" placeholder="{{ $project->description}}"></textarea>
                            </div>
                        </div>
                        <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver equipas do projeto
                                            <span class="float-end">
                                                <a href="{{ Route('teams.AddProjectToTeam', ['project_id' => $project->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
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
                                                        <td>
                                                            <a class="text-info ml-auto"href="{{ Route('teams.view', ['team_id'=>$team->id])}}"><i class="fa-solid fa-eye"></i></a>
                                                            <a class="text-danger ml-auto"href="{{ Route('teams.removeProject',['Teams_project_id'=>$team->id])}}"><i class="fa-solid fa-trash"></i></a>
                                                        </td>
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
                                                        <th class="actions text-center px-0 sorting_disabled">
                                                            <i class="fas fa-tools text-black"></i>
                                                        </th>
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
                        <button type="submit" class="btn btn-primary float-end mt-3">Atualizar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('projects.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection