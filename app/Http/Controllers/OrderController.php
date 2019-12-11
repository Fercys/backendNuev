<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contrato;
use App\ContratoProducto;
use App\Producto;
use App\Detalle;
use App\Encabezado;
use Carbon\Carbon;

class OrderController extends Controller
{
    /*@italo: Registro de Contratos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*
    {
        "id":2, //Este es el id del contrato, necesario para la validacion
        "f_entrega_deseada":"11-12-2019",
        "cantidad_kg": 10
    }
    */ 
    public function create(Request $request)
    {   
        $contract  = ContratoProducto::where('id_contrato',$request->input('id'))->first();  
        $product = Producto::find($contract['id_producto']); 
        $detail = Detalle::where('id_producto',$product['id'])->get();
        $quantity_accumulated = 0;
        foreach($detail as $element){
            $quantity_accumulated += $element['cantidad_kg'];
        }
        return $product['kilos'] > $quantity_accumulated  ? 
            response()->json(['Status' => 'Success', 'Value' => $this->insert_order($request->all(),$contract)]) : 
            response()->json(['Status' => 'Error', 'Value' => 'Valor no debe sobre pasar los '.$product['kilos'].' kilos']);        
    }
    /*@italo: Solicitud de Ordenes*/
    public function show(Request $request)
    {   
        $header = Encabezado::where('id',$request->route('id'))->first();
        
        $detail = Detalle::where('id_pedido',$header['id'])->first();
        $response = (object) array('pedido'=>$header,'detalle'=>$detail);
        return response()->json(['Status' => 'Success', 'Value' => $response]);    
    }
    /*@italo: Solicitud de todos los Ordenes*/
    public function show_all(Request $request)
    {   
        $header = Encabezado::all();
        $response = array();
        foreach($header as $element){
            $detail = Detalle::where('id_pedido', $element['id'])->first(); 
            $element_array_insert = (object) array('Encabezado'=>$element,'Detalle'=>$detail);
            array_push($response,$element_array_insert);
            unset($contract_product); unset($product);
        }
        return response()->json(['Status' => 'Success', 'Value' => $response]);    
    }
    /*@italo: Actulizacion de Ordenes*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "header":{
            "id_cliente": 4,
            "f_entrega_deseada": "2019-12-11"
        },
        "detail":{
            "cantidad_kg": 10
        }
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();        
        if(isset($data_request['header'])){   //Actualizacion al Encabezado, de solicitarse
            $header  = new Encabezado;
            /* Mapeo de las fechas, si son actualizadas */
            if(isset($data_request['header']['f_entrega_deseada'])){
                $data_request['header']['f_entrega_deseada'] = new Carbon($data_request['header']['f_entrega_deseada']);
            }
            /* ---------------------------------------- */
            $header->where('id', $request->route('id'))->update($data_request['header']);
        }        
        if(isset($data_request['detail'])){    //Actualizacion al Detalle, de solicitarse
            $detail = Detalle::where('id_pedido',$request->route('id'))->update($data_request['detail']);        
        }
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);           
    }
    public function destroy(Request $request)
    {
        $detail = new Detalle;
        $detail->where('id_pedido',$request->route('id'))->delete();
        $header = new Encabezado;
        $header->destroy($request->route('id'));
        //Detalle::where('id_pedido',$request->route('id'))->destroy();
        //Encabezado::destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
    private function insert_order($data,$contract_product){
        $detail = new Detalle;
        $contract = Contrato::where('id',$data['id'])->first();
        $header = new Encabezado;
        //@italo: Header Insert
        $header->id_cliente = $contract['id_cliente'];
        $header->f_entrega_deseada = new Carbon($data['f_entrega_deseada']);
        $header->f_creacion = Carbon::now();
        $header->save();
        //@italo: Detail Insert
        $detail->id_pedido = $header->id;
        $detail->id_producto = $contract_product['id_producto'];
        $detail->cantidad_kg = $data['cantidad_kg'];
        $detail->save();
        return 'Register Done';
    }
}
