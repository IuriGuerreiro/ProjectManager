@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        listar projetos
                        <span class="float-end">
                           <a href="{{Route('tasks.create')}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                        </span>
                    </div>
                    <div class="card-body table-responsive">
                        <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th class="actions text-center px-0 sorting_disabled">
                                        <i class="fas fa-tools text-black"></i>
                                    </th>
                                    <th>
                                        @Lang('codigo')
                                    </th>
                                    <th>
                                        @Lang('designação')
                                    </th>
                                    <th>
                                        @lang('estado')
                                    </th>
                                    <th>
                                        @Lang('descrição')
                                    </th>
                                    <th>
                                        @Lang('nome do projeto')
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                 <tr>
                                    <td>
                                        <a class="text-info ml-auto"href="{{ Route('tasks.view', ['id'=>$task->id])}}"><i class="fa-solid fa-eye"></i></a>
                                        <a class="text-warning ml-auto" href="{{ Route('tasks.edit', ['id'=>$task->id])}}"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a class="text-danger ml-auto"href="{{ Route('tasks.delete', ['id'=>$task->id]) }}"><i class="fa-solid fa-trash"></i></a></td>
                                    <td>{{ $task->task_code ?? '--'}}</td>
                                    <td>{{ $task->task_designation ?? '--'}}</td>
                                    <td>{{ $task->task_status ?? '--'}}</td>
                                    <td>{{ \Str::limit($task-> description,30) ?? '--'}}</td>
                                    <td>{{ $task->project_designation}}</td>
                                 </tr>
                                 @endforeach
                            </tbody>
                        </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection