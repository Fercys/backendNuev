<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reserva;

class ReservaController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "detalle":"prueba"
    } */ 
    public function create(Request $request)
    {
        $reserva  = new Reserva;
        $reserva->id_naviera = $request->input('id_naviera');
        $reserva->lote = $request->input('lote');
        $reserva->nro_reserva = $request->input('nro_reserva');
        $reserva->save();      
        return response()->json(['Status' => 'Success', 'Value' => $reserva]);
    }    
    /*@italo: Solicitud de Productos*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
        Reserva::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos los Productos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Reserva::all()]);
    }
    /*@italo: Actulizacion de Productos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "detalle":"prueba"
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();
        $naviera = new Reserva;
        $naviera->where('id', $request->route('id'))->update($data_request);
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);                 
    }
    public function destroy(Request $request)
    {
        $naviera  = new Reserva;
        $naviera->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
}
