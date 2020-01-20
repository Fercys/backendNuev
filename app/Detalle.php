<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $fillable = [
        'id_pedido','id_producto','cantidad_kg','direccion_entrega',
        'ciudad_entrega','pais_entrega','moneda','pais_origen',
        'puerto_origen','pais_destino','puerto_destino',
        'condicion_pago','agregar_icoterms'
    ];
}
