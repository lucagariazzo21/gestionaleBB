@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="float-left col">
                <h2>Impostazioni</h2>
            </div>
        </div>
        <hr>
        <form action="{{ route('settings.edit') }}">
            <div class="form-group row">
                <label for="nome" class="col-sm-3 col-form-label">Prezzo Camera Singola</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" min="1" name="single_room_price" placeholder="Prezzo Camera Singola" required value="{{ isset($data['single_room_price']) ? $data['single_room_price'] : '' }}">
                </div>
                €
            </div>

            <div class="form-group row">
                <label for="nome" class="col-sm-3 col-form-label">Prezzo Camera Doppia</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" min="1" name="room_price" placeholder="Prezzo Camera" required value="{{ isset($data['room_price']) ? $data['room_price'] : '' }}">
                </div>
                €
            </div>

            <div class="form-group row">
                <label for="nome" class="col-sm-3 col-form-label">Prezzo Letto in Aggiunta</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" min="1" name="added_bed_price" placeholder="Prezzo Letto in Aggiunta" required value="{{ isset($data['added_bed_price']) ? $data['added_bed_price'] : '' }}">
                </div>
                €  
            </div>

            <div class="form-group row">
                <label for="nome" class="col-sm-3 col-form-label">Prezzo Animale</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" min="1" name="has_animals_price" placeholder="Prezzo Animale" required value="{{ isset($data['has_animals_price']) ? $data['has_animals_price'] : '' }}">
                </div>
                €
            </div>

            <hr>
            <div class="form-group row">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary float-right">Salva</button>
                </div>
             </div>
        </form>
    </div>
@endsection