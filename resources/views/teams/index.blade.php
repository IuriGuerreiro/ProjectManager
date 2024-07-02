@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        listar equipas
                        <span class="float-end">
                           <a href="{{ route('teams.create')}}" class="text-sucess ml-auto"><i class="fa-solid fa-plus"></i></a>
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
                                        <a class="text-info ml-auto"href="{{ Route('teams.view', ['team_id'=>$team->id]) }}"><i class="fa-solid fa-eye"></i></a>
                                        <a class="text-warning ml-auto" href="{{ Route('teams.edit', ['team_id'=>$team->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a class="text-danger ml-auto"href=""><i class="fa-solid fa-trash"></i></a></td>
                                    <td>{{ $team->team_designation ?? '--'}}</td>
                                    <td>{{ $team->team_function}}</td>
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