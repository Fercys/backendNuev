<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    public $table = "planta";
    protected $fillable = [
        'nombre','direccion'
    ];
    public function producto() {
        return $this->hasMany(PlantaProducto::class);
    }
}
