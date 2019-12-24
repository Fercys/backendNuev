<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantaProducto extends Model
{
    protected $fillable = [
        'id_producto','id_planta','cantidad_kg','date_desde','date_hasta'
    ];
}
