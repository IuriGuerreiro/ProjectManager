@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    criar projeto
                </div>
                <div class="card-body">
                    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data"class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <label for="inputTeamDesignation">
                                    Designação da equipa
                                </label>
                                <input class="form-control" type="text" id="inputTeamDesignation"name="inputTeamDesignation" placeholder="Designação da equipa" value="{{old('inputTeamDesignation')}}" REQUIRED autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-6">
                                <label for="inputTeamFunction">
                                    função da equipa
                                </label>
                                <input class="form-control" type="text" id="inputTeamfunction"name="inputTeamfunction" placeholder="função da equipa" value="{{old('inputTeamfunction')}}" REQUIRED autocomplete="off">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">criar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('projects.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection