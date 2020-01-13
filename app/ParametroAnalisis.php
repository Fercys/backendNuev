<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametroAnalisis extends Model
{
    protected $fillable = [
        'IdParametroAnalisis','MaxValidValue','MinValidValue','Nombre','Nombre_en','UM','UM_en','id_agrotop'
    ];
}
