@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Adicionar utilizador a equipa
                </div>
                <div class="card-body">
                    <form action="{{Route('teams.storeUser', ['team_id' => $team->id])}}" method="POST" enctype="multipart/form-data" class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputProjectDesignation">
                                    designação da equipa
                                </label>
                                <span class="form-control">{{ $team->team_designation }}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputUserId">
                                    utilizador para adicionar
                                </label>
                                <select class="form-control" name="inputUserId" id="inputUserId">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <button type="submit" class="btn btn-primary float-end mt-3">adiconar</button>
                    </form>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('users.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection