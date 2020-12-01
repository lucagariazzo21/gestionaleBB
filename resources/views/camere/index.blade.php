@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="float-left">
                <h2>Camere</h2>
            </div>
        </div>
        <div class="col-4">
            <form action="{{ route('camere.index') }}" class="float-right">
                Filtra : <input type="text" name="filter" value="{{ $filter }}">
                <button class="btn btn-primary" type="submit">Cerca</button>
            </form>
        </div>
        <div class="col-4">
            <div class="float-right">
                <a class="btn btn-primary" data-toggle="modal" data-target="#modal-createCamera">Aggiungi</a>
            </div>
        </div>
    </div>
    <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Numero Letti</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @php
                $modal_count = 1;
            @endphp
            @if ($camere->count() > 0)    
                @foreach ($camere as $camera)
                    <tr>
                        <th>{{ $camera->nome }}</th>
                        <th>{{ $camera->n_letti }}</th>         
                        <th>
                            {{-- modifica --}}
                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editCamera-{{ $modal_count }}">Modifica</a>
                            <div class="modal fade" id="modal-editCamera-{{ $modal_count }}" tabindex="1" role="dialog" aria-labelledby="editCamera" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header bg-dark">
                                      <h5 class="modal-title" id="editCamera">Modifica camera</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body bg-dark">
                                        <div class="container">
                                            <form action="{{ route('camere.edit') }}" method="GET">
                                                <input type="hidden" name="id" value="{{ $camera->id }}">
                                                <div class="form-group row">
                                                    <label for="nome" class="col-sm-3 col-form-label"><b>Nome</b></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="nome" required value="{{ $camera->nome }}">
                                                    </div>
                                                </div>
                                        
                                                <div class="form-group row">
                                                    <label for="n_letti" class="col-sm-3 col-form-label"><b>Posti Letto</b></label>
                                                    <div class="col-sm-9">
                                                        <input type="number" min="1" class="form-control" name="n_letti" required  value="{{ $camera->n_letti }}">
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

                            {{-- cancellazione --}}
                            @if (!in_array($camera->id, $not_delete_rooms))    
                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-deleteCamera-{{ $modal_count }}">Elimina</a>
                                <div class="modal fade" id="modal-deleteCamera-{{ $modal_count }}" tabindex="1" role="dialog" aria-labelledby="deleteCamera" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                        <h5 class="modal-title" id="deleteCamera">Sei sicuro di eliminare la camera?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-footer bg-dark">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                                            <a type="button" class="btn btn-danger" href="{{ route('camere.destroy', ['camera' => $camera->id]) }}">Cancella</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        </th>
                    </tr>
                    @php
                        $modal_count++;
                    @endphp          
                @endforeach
            @else
                <tr><th colspan="8">Non sono stati trovati risultati...</th></tr>
            @endif
        </tbody>
    </table>
    {{ $camere->links() }}
</div>
@endsection

<div class="modal fade" id="modal-createCamera" tabindex="-1" role="dialog" aria-labelledby="createCamera" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-light" id="createCamera">Aggiungi una nuova camera</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-dark">
            <div class="container">
                <form action="{{ route('camere.create') }}" method="GET">
                    <div class="form-group row">
                        <label for="nome" class="col-sm-3 col-form-label"><b class="text-light">Nome</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nome" required placeholder="Nome">
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <label for="n_letti" class="col-sm-3 col-form-label"><b class="text-light">Posti Letto</b></label>
                        <div class="col-sm-9">
                            <input type="number" min="1" class="form-control" name="n_letti" required placeholder="Posti Letto">
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