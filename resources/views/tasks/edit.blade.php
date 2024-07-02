@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Editar tarefa
                </div>
                <div class="card-body">
                    <form action="{{Route('tasks.update', ['id' => $task->id])}}" method="POST" enctype="multipart/form-data" class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskDesignation" >
                                    designação do tarefa
                                </label>
                                <input autocomplete="off" class="form-control" type="text" id="inputTaskDesignation"name="inputTaskDesignation" placeholder="{{$task->task_designation}}" value="{{old('inputTaskDesignation')}}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskAcronimo">
                                    acronimo do tarefa
                                </label>
                                <span class="form-control">{{ $task->task_designation }}</span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskStatus" > estado do tarefa</label>
                                <select class="form-control" name="inputTaskStatus" id="inputTaskStatus" >
                                    <option >{{ $task->task_status }}</option>
                                    @foreach($PmStatus as $status)
                                        <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskProjectId">Selecione o projeto</label>
                                <select class="form-control" name="inputTaskProjectId" id="inputTaskProjectId" >
                                    <option value="{{$task->project_id}}"></option>
                                    @foreach($projects as $project)  
                                        <option value="{{$project->id}}">{{$project->project_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputTaskDescription">descrição do tarefa</label>
                                <textarea class="form-control" name="inputTaskDescription" id="inputTaskDescription" cols="30" rows="10" placeholder="{{ $task->description}}" ></textarea>
                            </div>
                        </div>
                        <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver Colaboradores do projeto
                                            <span class="float-end">
                                                <a href="{{ Route('users.AddToTask', ['project_id' => $task->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                                            </span>
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
                                                        <th>
                                                            @Lang('função')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $user->name ?? '--'}}</td>
                                                        <td>{{ $user->email ?? '--'}}</td>
                                                        <td>função</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">Atualizar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('tasks.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection