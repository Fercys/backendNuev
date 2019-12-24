<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Planta;

class PlantaController extends Controller
{
    /*@italo: Registro de Plantas*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "nombre":"prueba",
        "direccion": "direccion de prueba"
    } */ 
    public function create(Request $request)
    {
        $plant  = new Planta;
        $plant->nombre = $request->input('nombre');
        $plant->direccion = $request->input('direccion');
        $plant->save();      
        return response()->json(['Status' => 'Success', 'Value' => $plant]);
    }    
    /*@italo: Solicitud de Plantas*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
            Planta::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos las Plantas*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Planta::all()]);
    }
    /*@italo: Actulizacion de Plantas*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "nombre":"prueba",
        "direccion": "direccion de prueba"
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();
        $product = new Planta;
        $product->where('id', $request->route('id'))->update($data_request);
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);                 
    }
    public function destroy(Request $request)
    {
        $product  = new Planta;
        $product->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
}
