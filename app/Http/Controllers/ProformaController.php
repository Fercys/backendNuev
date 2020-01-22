<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Proforma;

class ProformaController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "detalle":"prueba"
    } */ 
    public function create(Request $request)
    {
        $naviera  = new Proforma;
        $naviera->nombre = $request->input('nombre');
        $naviera->save();      
        return response()->json(['Status' => 'Success', 'Value' => $naviera]);
    }    
    /*@italo: Solicitud de Productos*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
        Naviera::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos los Productos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Naviera::all()]);
    }
    /*@italo: Actulizacion de Productos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "detalle":"prueba"
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();
        $naviera = new Proforma;
        $naviera->where('id', $request->route('id'))->update($data_request);
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);                 
    }
    public function destroy(Request $request)
    {
        $naviera  = new Proforma;
        $naviera->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
}
