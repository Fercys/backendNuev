<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PlantaProducto;

class plantaproductocollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'planta_producto'=>PlantaProducto::find($this->id),
            'planta'=>$this->planta[0],
            'producto'=>$this->producto[0]
        ];
    }
}
