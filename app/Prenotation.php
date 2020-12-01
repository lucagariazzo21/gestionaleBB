<?php

namespace App;

use App\Room;
use App\Client;
use Illuminate\Database\Eloquent\Model;

class Prenotation extends Model
{
    protected $fillable = [
            'nome',
            'n_persone',
            'data_arrivo',
            'data_partenza',
            'ora_arrivo',
            'ora_partenza',
            'camera_id',
            'has_animals',
            'ricavo',
            'client_id',
            'sconto',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'camera_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
