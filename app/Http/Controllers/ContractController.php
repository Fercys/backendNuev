<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Contrato;
use App\ContratoProducto;
use App\Producto;
use App\Detalle;
use App\Encabezado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContractController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    
    /*@italo: Registro de Contratos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "contract":{
            "f_inicio":"25-12-2019",
            "f_final":"27-12-2019"
        }
    } */ 
    public function create(Request $request)
    {
        $data_request = $request->all();
        $contract  = new Contrato;        
        try{
            $contract->f_inicio = new Carbon($data_request['contract']['f_inicio']);
            $contract->f_final = new Carbon($data_request['contract']['f_final']);
            $contract->save();               
        }catch(Exception $e){
            return response()->json(['Status' => 'Error', 'Value' => $e]);
        }        
        return response()->json(['Status' => 'Success', 'Value' => $contract]);
    }    
    /*@italo: Solicitud de Contratos*/
    public function show(Request $request)
    {
        $contract = Contrato::where('id',$request->route('id'))->first();
        return response()->json(['Status' => 'Success', 'Value' => $contract]);
    }
    /*@italo: Solicitud de todos los Contratos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
            $contract = Contrato::all()]);
    }
    /*@italo: Actulizacion de Contratos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "contract":{
            "f_inicio":"25-12-2019",
            "f_final":"27-12-2019"
        }
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();        
        if(isset($data_request['contract'])){   //Actualizacion al contrato, de solicitarse
            $contract  = new Contrato;
            /* Mapeo de las fechas, si son actualizadas */
            if(isset($data_request['contract']['f_inicio'])){
                $data_request['contract']['f_inicio'] = new Carbon($data_request['contract']['f_inicio']);
            }
            if(isset($data_request['contract']['f_final'])){
                $data_request['contract']['f_final'] = new Carbon($data_request['contract']['f_final']);
            }
            /* ---------------------------------------- */
            $contract->where('id', $request->route('id'))->update($data_request['contract']);            
        }
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);           
    }
    public function destroy(Request $request)
    {
        $contract  = new Contrato;
        $contract->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }    
}
