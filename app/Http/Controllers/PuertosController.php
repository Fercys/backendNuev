<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Puertos;

class PuertosController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "detalle":"prueba"
    } */ 
    public function create(Request $request)
    {
        $puerto  = new Puertos;
        $puerto->nombre = $request->input('nombre');
        $puerto->save();      
        return response()->json(['Status' => 'Success', 'Value' => $puerto]);
    }    
    /*@italo: Solicitud de Productos*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
        Puertos::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos los Productos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Puertos::all()]);
    }
    /*@italo: Actulizacion de Productos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "detalle":"prueba"
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();
        $puerto = new Puertos;
        $puerto->where('id', $request->route('id'))->update($data_request);
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);                 
    }
    public function destroy(Request $request)
    {
        $puerto  = new Puertos;
        $puerto->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
}
