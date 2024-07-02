@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    criar formação
                </div>
                <div class="card-body">
                    <form action="{{ route('formers.store') }}" method="POST" enctype="multipart/form-data"class="form-group">
                        @csrf 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputFormerName">
                                     Nome do formador
                                </label>
                                <input class="form-control" type="text" id="inputFormerName"name="inputFormerName" placeholder="Nome do formador" value="{{old('inputProjectDesignation')}}" REQUIRED autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputFormerEmail">
                                    Email do formador
                                </label>
                                <input class="form-control" type="text" id="inputFormerEmail"name="inputFormerEmail" placeholder="Email do formador" value="{{old('inputProjectAcronimo')}}" REQUIRED autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="inputFormerTrainings[]">Formações para o formador</label>
                                <div class="form-control">
                                    @foreach($trainings as $training)
                                        <input type="checkbox" name="inputFormerTrainings[]" id="inputFormerTrainings[]" value="{{ $training->id }} "> {{ $training->trainings_designation }}
                                        <br>
                                    @endforeach
                                </div>
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