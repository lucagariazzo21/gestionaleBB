@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="float-left col">
                <h2>Statistiche</h2>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="annuale-tab" data-toggle="tab" href="#annuale" role="tab" aria-controls="annuale" aria-selected="true">Annuale</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" id="generale-tab" data-toggle="tab" href="#generale" role="tab" aria-controls="generale" aria-selected="true">Generale</a>
              </li> --}}
          </ul>
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="annuale" role="tabpanel" aria-labelledby="annuale-tab">
                <div class="row">
                    <div class="col-8">
                        @if (!empty($data))
                            <canvas id="myChart" width="400" height="400" data-grafico = "{{ json_encode($data) }}"></canvas>
                        @else    
                            <b class="text-danger">Non sono stati trovati risultati...</b>
                        @endif
                    </div>
                    <div class="col-4 mt-4">
                        <div class="mb-3">
                            <form action="{{ route('ricavi.index') }}">
                                Seleziona anno :
                                <input type="text" name="year" pattern="\d{4}" placeholder="Inserisci un anno" value="{{ $year }}">
                                <button class="btn btn-primary" type="submit">Cerca</button>
                            </form>
                        </div>
                        
                        <div class="alert alert-success" role="alert">
                            <h3>{{ $year }}</h3>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-success">Ricavo</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="float-right">{{ $tot['ricavo'] }} €</h3> 
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-success">Prenotazioni</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="float-right">{{ $tot['prenotazioni'] }}</h3>
                                </div>
                            </div>
                            {{-- <hr> --}}
                        </div>

                        <div class="alert alert-primary" role="alert">
                            <h3 class="text-primary">Totale</h3>
                            <hr class="bg-color-primary">
                            <div class="row">
                                <div class="col">
                                    <h3>Ricavo</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="text-primary float-right">{{ $tot['tot_ricavo'] }} €</h3> 
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h3>Prenotazioni</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="text-primary float-right">{{ $tot['tot_prenotazioni'] }}</h3>
                                </div>
                            </div>
                            {{-- <hr> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="tab-pane fade" id="generale" role="tabpanel" aria-labelledby="generale-tab">
                <div class="row">
                    <div class="col-8">
                        @if (!empty($data))
                            <canvas id="myChart" width="400" height="400" data-grafico = "{{ json_encode($data) }}"></canvas>
                        @else    
                            <b class="text-danger">Non sono stati trovati risultati...</b>
                        @endif
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <form action="{{ route('ricavi.index') }}">
                                Seleziona un periodo : 
                                <select name="periodo" id="periodo">
                                    <option value="5">Ultimi 5 anni</option>
                                    <option value="10">Ultimi 10 anni</option>
                                    <option value="tot">Totale</option>
                                </select>
                                <button class="btn btn-primary" type="submit">Cerca</button>
                            </form>
                        </div>
                        <h3>{{ $year }}</h3>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <h3>Ricavo :</h3> 
                            </div>
                            <div class="col">
                                <h3 class="text-success float-right">{{ $tot[$year]['ricavo'] }} €</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <h3>Prenotazioni :</h3> 
                            </div>
                            <div class="col">
                                <h3 class="text-success float-right">{{ $tot[$year]['prenotazioni'] }}</h3>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    
    @endsection