<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $fillable = [
        'id_pedido','id_producto','cantidad_kg'
    ];
}
