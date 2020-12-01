@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="float-left">
                    <h2>Clienti</h2>
                </div>
            </div>
            <div class="col-4">
                <form action="{{ route('client.index') }}" class="float-right">
                    Filtra : <input type="text" name="filter" value="{{ $filter }}">
                    <button class="btn btn-primary" type="submit">Cerca</button>
                </form>
            </div>
        </div>
        <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th scope="col">Nome</th>
                <th scope="col">Ora Sveglia</th>
                <th scope="col">Colazione</th>
                <th scope="col">Azioni</th>
              </tr>
            </thead>
            <tbody>
                @if ($clienti->count() > 0)    
                    @foreach ($clienti as $cliente)
                        <tr>
                            <th>{{ $cliente->nome }}</th>
                            <th>{{ $cliente->ora_sveglia != 0 ?: null }}</th>         
                            <th>{{ $cliente->colazione }}</th>
                            <th>
                                {{-- modifica --}}
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editCliente-{{ $cliente->id }}">Modifica</a>
                                <div class="modal fade" id="modal-editCliente-{{ $cliente->id }}" tabindex="1" role="dialog" aria-labelledby="editCliente" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                        <h5 class="modal-title" id="editCliente">Modifica Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body bg-dark">
                                            <div class="container">
                                                <form action="{{ route('client.edit') }}" method="GET">
                                                    <input type="hidden" name="id" value="{{ $cliente->id }}">
                                                    <div class="form-group row">
                                                        <label for="nome" class="col-sm-3 col-form-label"><b>Nome</b></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="nome" required value="{{ $cliente->nome }}">
                                                        </div>
                                                    </div>
                                            
                                                    <div class="form-group row">
                                                        <label for="n_letti" class="col-sm-3 col-form-label"><b>Ora Sveglia</b></label>
                                                        <div class="col-sm-9">
                                                            <input type="time" class="form-control" name="ora_sveglia" required  value="{{ $cliente->ora_sveglia }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="n_letti" class="col-sm-3 col-form-label"><b>Colazione</b></label>
                                                        <div class="col-sm-9">
                                                            <textarea name="colazione" cols="42" rows="5">{{ $cliente->colazione }}</textarea>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="form-group row">
                                                        <div class="col-sm-7">
                                                        <button type="submit" class="btn btn-primary float-right">Salva</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>      
                            </th>   
                        </tr>          
                    @endforeach
                @else
                    <tr><th colspan="8">Non sono stati trovati risultati...</th></tr>
                @endif
            </tbody>
        </table>
        {{ $clienti->links() }}
    </div>
@endsection