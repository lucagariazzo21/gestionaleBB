@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-2">
            <span class="badge" style="background-color: lightgreen;">&nbsp&nbsp</span> camera disponobile 
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: yellow;">&nbsp&nbsp</span> controlla le camere
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: red;">&nbsp&nbsp</span> camere occupate
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: lightgrey;">&nbsp&nbsp</span> giorni passati
        </div>
    </div>
    <hr>
    <div class="float-left">
        <h2>Agenda</h2>
    </div>
    <div class="float-right">
        <form action="{{ route('agenda') }}">
            Seleziona un giorno : <input type="date" name="day" value="{{ $day }}">
            <button class="btn btn-primary" type="submit">Cerca</button>
        </form>
    </div>
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Giorno</th>
            <th scope="col">Stato</th>
            <th scope="col">Informazioni</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @php
                $n_modal = 1;
            @endphp
            @foreach ($period as $date)
                @php
                    $count_ora_arrivo = 0;
                    $status = '';
                    if (date('Y-m-d') <= $date->format('Y-m-d')) {
                        if(empty($array[$date->format('Y-m-d')])) {
                            $status = 'lightgreen';
                        } elseif (count($array[$date->format('Y-m-d')]) < $tot_camere) {
                            $status = 'lightgreen';
                        } elseif (count($array[$date->format('Y-m-d')]) == $tot_camere) {
                            foreach ($array[$date->format('Y-m-d')] as $value) {
                                foreach ($value as $item) {
                                    if (isset($item['ora_arrivo'])) {
                                        $count_ora_arrivo++;
                                    }
                                    if (!isset($item['ora_arrivo']) && !isset($item['ora_partenza'])) {
                                        $count_ora_arrivo++;
                                    }
                                    if (isset($item['ora_partenza']) && !isset($item['ora_partenza'])) {
                                        break;
                                    }
                                }
                            }
                            if ($count_ora_arrivo == $tot_camere) {
                                $status = 'red';
                            } else {
                                $status = 'yellow';
                            }
                        }
                    } else {
                        $status = 'lightgrey';
                    }
                @endphp
                <tr style="background-color: {{ $status }};">
                    <th>
                        <b class="{{ $date->format('Y-m-d') == $day ? 'text-primary' : '' }}">{{ $date->format('d/m/Y') }}</b>
                    </th>
                    <th>
                        @if (!empty($array[$date->format('Y-m-d')]) && $count_ora_arrivo < $tot_camere)
                            camere occupate : {{ count($array[$date->format('Y-m-d')]) }}
                        @elseif($date->format('Y-m-d') >= date('Y-m-d') && $count_ora_arrivo == $tot_camere)
                            OCCUPATO
                        @elseif (empty($array[$date->format('Y-m-d')]))
                            LIBERO
                        @endif
                    </th>
                    <th>
                        @if (!empty($array[$date->format('Y-m-d')]))    
                            <button class="btn btn-primary btn-sm view-info" data-toggle="modal" data-target="#modal-info-{{ $n_modal }}">
                                <i class="fa fa-eye"></i>INFO
                            </button>
                            <div class="modal fade" id="modal-info-{{ $n_modal }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Informazioni {{ $date->format('d/m/Y') }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body info">
                                        @if (!empty($array[$date->format('Y-m-d')]))
                                            @foreach ($array[$date->format('Y-m-d')] as $camera => $item)
                                                <h5>{{ $camera }}</h5>
                                                @foreach ($item as $value)   
                                                    @if (isset($value['ora_arrivo']))
                                                        arriva <b class="text-primary">{{ $value['cliente'] }}</b> alle <b class="text-success">{{ $value['ora_arrivo'] }}</b><br>
                                                    @elseif (isset($value['ora_partenza']))
                                                        parte <b class="text-primary">{{ $value['cliente'] }}</b> alle <b class="text-danger">{{ $value['ora_partenza'] }}</b><br>
                                                    @else
                                                        occupata da <b class="text-primary">{{ $value['cliente'] }}</b> tutto il giorno<br>
                                                    @endif
                                                    @if ($value['ora_sveglia'] && $value['ora_sveglia'] != 0)
                                                        <div>Ora sveglia : <b class="text-info">{{ $value['ora_sveglia'] }}</b></div>
                                                    @endif
                                                    @if ($value['colazione'])
                                                        <div>Colazione : <b class="text-info">{{ $value['colazione'] }}</b></div>
                                                    @endif
                                                @endforeach
                                                <hr>
                                            @endforeach
                                        @endif
                                    </div>
                                  </div>
                                </div>
                            </div>
                        @endif
                    </th>
                    <th>
                        @php
                            $max_hour = null;
                            if(!empty($array[$date->format('Y-m-d')])) {
                                $count = 0;
                                if (count($array[$date->format('Y-m-d')]) == $tot_camere) {
                                    foreach ($array[$date->format('Y-m-d')] as $value) {
                                        if (count($value) < 2) {
                                            foreach ($value as $item) {
                                                if (isset($item['ora_partenza'])) {
                                                    if ($count == 0) {
                                                        $max_hour = $item['ora_partenza'];
                                                    } elseif($max_hour > $item['ora_partenza']) {
                                                        $max_hour = $item['ora_partenza'];
                                                    }
                                                }
                                            }
                                            $count++;
                                        }
                                    }
                                }
                            }
                        @endphp
                        @if (date('Y-m-d') <= $date->format('Y-m-d') && $count_ora_arrivo < $tot_camere)    
                            <a class="btn btn-primary btn-sm" href="{{ route('prenotazioni.detail', ['day' => $date->format('Y-m-d'), 'ora_max' => $max_hour]) }}">
                                Aggiungi
                            </a>
                        @endif
                    </th>
                </tr>
                @php
                    $n_modal++;
                @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection
