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
            "id_cliente":4,
            "f_final":"27-12-2019"
        },
        "product":{
            "kilos":100
        }
    } */ 
    public function create(Request $request)
    {
        $data_request = $request->all();
        $contract  = new Contrato;        
        try{
            //@italo: Contract Insert
            $contract->id_cliente = $data_request['contract']['id_cliente'];
            $contract->f_inicio = new Carbon($data_request['contract']['f_inicio']);
            $contract->f_final = new Carbon($data_request['contract']['f_final']);
            $contract->save();                    
            //@italo: Product Insert and Relations
            $product  = new Producto;
            $contract_product = new ContratoProducto;
            $product->kilos = $data_request['product']['kilos'];
            $product->save();
            $contract_product->id_producto = $product->id;
            $contract_product->id_contrato = $contract->id; 
            $contract_product->save();               
        }catch(Exception $e){
            return response()->json(['Status' => 'Error', 'Value' => $e]);
        }        
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Creado']);
    }    
    /*@italo: Solicitud de Contratos*/
    public function show(Request $request)
    {
        $contract = Contrato::where('id',$request->route('id'))->first();
        $contract_product = ContratoProducto::where('id_contrato',$request->route('id'))->first();
        $product = Producto::where('id', $contract_product['id_producto'])->first();
        $response = (object) array('contract'=>$contract,'product'=>$product);
        return response()->json(['Status' => 'Success', 'Value' => $response]);
    }
    /*@italo: Solicitud de todos los Contratos*/
    public function show_all(Request $request)
    {
        $contract = Contrato::all();
        $response = array();
        foreach($contract as $element){
            $contract_product = ContratoProducto::where('id_contrato',$element['id'])->first();
            $product = Producto::where('id', $contract_product['id_producto'])->first(); 
            $element_array_insert = (object) array('contract'=>$element,'product'=>$product);
            array_push($response,$element_array_insert);
            unset($contract_product); unset($product);
        }
        return response()->json(['Status' => 'Success', 'Value' => $response]);
    }
    /*@italo: Actulizacion de Contratos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "contract":{
            "id_cliente":4,
            "f_final":"27-12-2019"
        },
        "product":{
            "kilos":100
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
        if(isset($data_request['product'])){    //Actualizacion al producto, de solicitarse
            $contract_product = ContratoProducto::where('id_contrato',$request->route('id'))->first();               
            $product = Producto::where('id', $contract_product['id_producto'])->update($data_request['product']);
        }
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);           
    }
    public function destroy(Request $request)
    {
        $contract  = new Contrato;
        $contract_product = ContratoProducto::where('id_contrato',$request->route('id'))->first(); 
        $product  = new Producto;
        $product->destroy($contract_product['id_producto']);
        $contract_product->destroy($contract_product['id']);
        $contract->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }    
}
