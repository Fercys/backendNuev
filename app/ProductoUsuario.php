<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoUsuario extends Model
{
    protected $fillable = [
        'id_producto','id_users'
    ];
}
