@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Ver formação
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="inputtrainingDesignation">
                                    codigo do projeto
                                </label>
                                <span class="form-control">{{ $training->trainings_code }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputTrainingstatus">Designação</label>
                                <span class="form-control">{{ $training->trainings_designation }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputTrainingstatus">estado</label>
                                <span class="form-control">{{ $training->status }}</span>
                            </div>


                            <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver utilizadores da formação
                                            <span class="float-end">
                                                <a href="{{ Route('trainings.addUsers',['training_id'=>$training->id]) }}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            @Lang('nome ')
                                                        </th>
                                                        <th>
                                                            @Lang('email')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $user)
                                                    <tr>
                                                        <td><a href="{{ Route('users.view', ['user_id'=>$user->id])}}">{{ $user->name ?? '--'}}</a></td>
                                                        <td><a href="{{ Route('users.view', ['user_id'=>$user->id])}}">{{ $user->email ?? '--'}}</a></td>
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
                                            Ver formadores 
                                            <span class="float-end">
                                                <a href="" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            @Lang('nome ')
                                                        </th>
                                                        <th>
                                                            @Lang('email')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($formers as $former)
                                                    <tr>
                                                        <td><a href="{{ Route('formers.view', ['former_id'=>$former->id])}}">{{ $former->name ?? '--'}}</a></td>
                                                        <td><a href="{{ Route('formers.view', ['former_id'=>$former->id])}}">{{ $former->email ?? '--'}}</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('trainings.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection