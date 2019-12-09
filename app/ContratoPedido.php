<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoPedido extends Model
{
    protected $fillable = [
        'id_producto','id_contrato'
    ];
}
