@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Criar colaborador de projeto
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="inputUserName">
                                    Nome de Utilizador
                                </label>
                                <input autocomplete="off" class="form-control" type="text" id="inputUserName"name="inputUserName" placeholder="nome do utilizador" value="{{old('inputProjectDesignation')}}" REQUIRED>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputUserEmail">
                                    Email do utilizador
                                </label>
                                <input autocomplete="off" class="form-control" type="text" id="inputUserEmail"name="inputUserEmail" placeholder="Email do utilizador" value="{{old('inputProjectAcronimo')}}" REQUIRED>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inoputUserPassword" > password do utilizador</label>
                                <input autocomplete="off" class="form-control" type="text" id="inputUserPassword"name="inputUserPassword" placeholder="password do utilizador" value="{{old('inputProjectAcronimo')}}" REQUIRED>
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