<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'detalle','precio'
    ];
    public function planta() {
        return $this->hasMany(PlantaProducto::class,'id');
    }
}
