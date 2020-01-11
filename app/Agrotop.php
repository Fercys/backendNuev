<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agrotop extends Model
{
    protected $fillable = [
        'Cliente','Codigo','FamiliaProducto','Fumigacion','Granel',
        'HumedadRelativa','IdCliente','IdClienteSap','IdFichaTecnica','Observacion',
        'Pais','PesoTotalPickingTest','Producto','Sag','Temperatura','VerificacionCliente',
        'Version','VidaUtil','id_user'
    ];
}
