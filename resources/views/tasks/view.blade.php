@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Ver tarefa
                    <span class="float-end">
                        <a href="{{ Route('tasks.edit', ['id' => $task->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-edit"></i></a>
                    </span>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="inputtaskDesignation">
                                    codigo da tarefa
                                </label>
                                <span class="form-control">{{ $task->task_code }}</span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputtaskStatus">Designação</label>
                                <span class="form-control">{{ $task->task_designation }}</span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputtaskStatus">estado</label>
                                <span class="form-control">{{ $task->task_status }}</span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputtaskStatus">nome do projeto</label>
                                <span class="form-control">{{ $project->project_designation }}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputtaskDescription">descrição da tarefa</label>
                                <hr class="mt-0">
                                {{ $task->description }}
                            </div>
                        </div>

                        <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver Colaboradores do projeto
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
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('tasks.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection