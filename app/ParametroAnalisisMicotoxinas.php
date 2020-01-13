<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametroAnalisisMicotoxinas extends Model
{
    protected $fillable = [
        'MaxValidValue','MinValidValue','Nombre','Nombre_en','UM','UM_en','id_agrotop'
    ];
}
