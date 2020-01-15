<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Naviera_Puertos extends Model
{
    protected $fillable = [
        'id_naviera','id_puerto','dias'
    ];
}
