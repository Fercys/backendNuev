<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sacos extends Model
{
    protected $fillable = [
        'ColorHilo','Descripcion','IdSaco','Nombre','Peso','id_agrotop'
    ];
}
