@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="card">
                <div class="card-header">
                    Ver Formador
                    <span class="float-end">
                        <a href="{{ Route('formers.edit', ['former_id' => $former->id])}}" class="text-sucess ml-auto"><i class="fa-solid fa-edit"></i></a>
                    </span>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputformerDesignation">
                                    codigo do projeto
                                </label>
                                <span class="form-control">{{ $former->name }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputformerstatus">Designação</label>
                                <span class="form-control">{{ $former->email }}</span>
                            </div>


                            <div class="container">
                                <div class="mt-5">
                                    <div class="card">
                                        <div class="card-header">
                                            Ver formações em que participou
                                        </div>
                                        <div class="card-body">
                                            <table {{-- id="datatable-Automatic" --}} class="object-table table table-sm table-bordered table-striped" style="width: 100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>
                                                            @Lang('Codigo da formação')
                                                        </th>
                                                        <th>
                                                            @Lang('designação da formação')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($trainings as $training)
                                                    <tr>
                                                        <td>{{ $training->trainings_code ?? '--'}}</td>
                                                        <td>{{ $training->trainings_designation ?? '--'}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <a type="button "class="btn btn-secondary float-end m-3" title="voltar a pagina anterior" href="{{ Route('formers.list')}}"><i class="fa-solid fa-arrow-left"></i></a></td>
                </div>
            </div>
        </div>
    </div>
@endsection