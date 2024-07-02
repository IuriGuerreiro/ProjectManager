@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    criar projeto
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data"class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskAcronomico"> Acronómico da tarefa</label>
                                <input autocomplete="off" class="form-control" type="text" id="inputTaskAcronomico"name="inputTaskAcronomico" placeholder="acronomico da tarefa" value="{{old('inputTaskAcronimo')}}" REQUIRED>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskDesignation">
                                    designação da tarefa
                                </label>
                                <input autocomplete="off" class="form-control" type="text" id="inputTaskDesignation"name="inputTaskDesignation" placeholder="designação da tarefa" value="{{old('inputTaskDesignation')}}" REQUIRED>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskStatus" > estado da tarefa</label>
                                <select class="form-control" name="inputTaskStatus" id="inputTaskStatus" >
                                    @foreach($PmStatus as $status)  
                                        <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="inputTaskProjectId">Selecione o projeto</label>
                                <select class="form-control" name="inputTaskProjectId" id="inputProjectStatus" >
                                    @foreach($projects as $project)  
                                        <option value="{{$project->id}}">{{$project->project_designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputProjectDescription">descrição da tarefa</label>
                                <textarea class="form-control" name="inputTaskDescription" id="inputTaskDescription" cols="30" rows="10" ></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">Registrar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('projects.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection