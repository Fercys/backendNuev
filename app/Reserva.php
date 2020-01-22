<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'id_naviera',
        'lote',
        'nro_reserva'      

    ];
}
