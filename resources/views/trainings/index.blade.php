@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        listar formações 
                        <span class="float-end">
                           <a href="{{ route('trainings.create')}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
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
                                        @Lang('codigo do formações')
                                    </th>
                                    <th>
                                        @Lang('designação do formações')
                                    </th>
                                    <th>
                                        @Lang('estado do formações')
                                    </th>
                                    <th>
                                        @Lang('participantes')
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainings as $training)
                                 <tr>
                                    <td>
                                        <a class="text-info ml-auto"href="{{ Route('trainings.view', ['training_id'=>$training['id']]) }}"><i class="fa-solid fa-eye"></i></a>
                                        <a class="text-warning ml-auto" href="{{ Route('trainings.edit', ['training_id'=>$training['id']]) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a class="text-danger ml-auto"href="{{ Route('trainings.delete', ['training_id'=>$training['id']]) }}"><i class="fa-solid fa-trash"></i></a></td>
                                    <td>{{ $training['trainings_code'] ?? '--'}}</td>
                                    <td>{{ $training['trainings_designation'] ?? '--'}}</td>
                                    <td>{{ $training['status'] ?? '--'}}</td>
                                    <td>{{ $training['participants'] ?? '--'}}</td>
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