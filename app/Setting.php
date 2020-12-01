<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'single_room_price',
        'room_price',
        'added_bed_price',
        'has_animals_price',
    ];
}
