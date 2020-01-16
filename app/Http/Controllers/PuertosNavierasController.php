<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Naviera_Puertos;

class PuertosNavierasController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "detalle":"prueba"
    } */ 
    public function create(Request $request)
    {
        $array_element = $request->all();
        foreach ($array_element as $key => $value) {
            $naviera_puerto_validate = Naviera_Puertos::where(['id_naviera'=>$value['id_naviera'],'id_puerto'=>$value['id_puerto']])->first();
            if($naviera_puerto_validate != null){
                return response()->json(['Status' => 'Error', 'Value' => 'registro repetido','Register'=>$naviera_puerto_validate]);
            }
        }
        foreach ($array_element as $key => $value) {
            $naviera_puerto  = new Naviera_Puertos;
            $naviera_puerto->id_naviera = $value['id_naviera'];
            $naviera_puerto->id_puerto = $value['id_puerto'];
            $naviera_puerto->dias = $value['dias'];
            $naviera_puerto->save(); 
        }             
        return response()->json(['Status' => 'Success', 'Value' => 'Registros Agregados']);
    }    
    /*@italo: Solicitud de Productos*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
        Naviera_Puertos::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos los Productos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Naviera_Puertos::all()]);
    }
    /*@italo: Actulizacion de Productos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "detalle":"prueba"
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();
        $puerto = new Naviera_Puertos;
        $puerto->where('id', $request->route('id'))->update($data_request);
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);                 
    }
    public function destroy(Request $request)
    {
        $puerto  = new Naviera_Puertos;
        $puerto->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
}
