@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Ver tarefa
                    <span class="float-end">
                        <a href="" class="text-sucess ml-auto"><i class="fa-solid fa-edit"></i></a>
                    </span>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputuserDesignation">
                                    nome do colaborador
                                </label>
                                <span class="form-control">{{ $users->name }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputuserstatus">Email do colaborador</label>
                                <span class="form-control">{{ $users->email }}</span>
                            </div>
                        </div>
                            <div class="mt-5">
                                <div class="card">
                                    <div class="card-header">
                                        Ver projetos do utilizador
                                    </div>
                                    <div class="card-body">
                                            <div class="row">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            @Lang('codigo do projeto')
                                                        </th>
                                                        <th>
                                                            @Lang('designação do projeto')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($projects as $project)
                                                    <tr>
                                                        <td>{{ $project->project_code ?? '--'}}</td>
                                                        <td>{{ $project->project_designation ?? '--'}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="card">
                                    <div class="card-header">
                                        Ver tarefas do colaborador
                                    </div>
                                    <div class="card-body">
                                            <div class="row">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="actions text-center px-0 sorting_disabled">
                                                            <i class="fas fa-tools text-black"></i>
                                                        </th>
                                                        <th>
                                                            @Lang('codigo da tarefa')
                                                        </th>
                                                        <th>
                                                            @Lang('designação da tarefa')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tasks as $task)
                                                    <tr>
                                                        <td>
                                                            <a class="text-danger ml-auto"href="{{ Route('users.removeFromTask', ['id'=>$task->id]) }}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $task->task_code ?? '--'}}</td>
                                                        <td>{{ $task->task_designation ?? '--'}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                <div class="card">
                                    <div class="card-header">
                                        Ver Funções do colaborador
                                        <span class="float-end">
                                            <a href="{{Route('users.addRole', ['user_id'=>$users->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="actions text-center px-0 sorting_disabled">
                                                            <i class="fas fa-tools text-black"></i>
                                                        </th>
                                                        <th>
                                                            @Lang('Nome da função')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $role)
                                                    <tr>
                                                        <td>
                                                            <a class="text-danger ml-auto" href="{{ route('users.removeRole', ['id'=>$role->id])}}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{ $role->role_designation ?? '--'}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('users.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection