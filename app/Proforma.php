<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $fillable = [
        'direccion_entrega',
        'ciudad_entrega',
        'pais_entrega',
        'moneda',
        'pais_origen',
        'puerto_origen',
        'pais_destino',
        'puerto_destino',
        'condicion_pago',
        'incoterms'

    ];

 
}
