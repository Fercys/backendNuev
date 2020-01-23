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
        $proforma  = new Proforma;
        $proforma->direccion_entrega = $request->input('direccion_entrega');
        $proforma->ciudad_entrega = $request->input('ciudad_entrega');
        $proforma->pais_entrega = $request->input('pais_entrega');
        $proforma->moneda = $request->input('moneda');
        $proforma->pais_origen = $request->input('pais_origen');
        $proforma->puerto_origen = $request->input('puerto_origen');
        $proforma->pais_destino = $request->input('pais_destino');
        $proforma->puerto_destino = $request->input('puerto_destino');
        $proforma->condicion_pago = $request->input('condicion_pago');
        $proforma->incoterms = $request->input('incoterms');
        $proforma->save();      
        return response()->json(['Status' => 'Success', 'Value' => $proforma]);
    }    
    /*@italo: Solicitud de Productos*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
        Proforma::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos los Productos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Proforma::all()]);
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
