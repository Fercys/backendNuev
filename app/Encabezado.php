<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encabezado extends Model
{
    protected $fillable = [
        'autorizado','nro_sap','op','proforma','reserva',
        'id_cliente','f_entrega_deseada','f_creacion'
    ];
}
