<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoProducto extends Model
{
    public $table = "contrato_producto";
    protected $fillable = [
        'id_producto','id_contrato'
    ];
}
