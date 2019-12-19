<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contrato;
use App\ContratoProducto;
use App\Producto;
use App\Detalle;
use App\Encabezado;
//use App\User;
use Carbon\Carbon;

class OrderController extends Controller
{
    /*@italo: Registro de Contratos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*
    {
        "id":2, //Este es el id del contrato, necesario para la validacion
        "f_entrega_deseada":"11-12-2019",
        "id_producto":1,
        "cantidad_kg": 10,
        "f_creacion":"10-12-2019",
        "id_cliente":1
    }
    */ 
    public function create(Request $request)
    {   
        if(Contrato::where([
            ['id_user','=',$request->input('id_cliente')],
            ['id','=',$request->input('id')]
        ])->count() < 1){
            return response()->json(['Status' => 'Error', 'Value' => 'No existe contrato relacionado con ese usuario']);
        }
        $contract  = ContratoProducto::where([
            ['id_contrato','=',$request->input('id')],
            ['id_producto','=',$request->input('id_producto')]
        ])->first();
        if(empty($contract)){
            return response()->json(['Status' => 'Error', 'Value' => 'No existe contrato relacionado con ese producto']);
        }  
        $detail = Detalle::where('id_producto',$request->input('id_producto'))->get();
        $quantity_accumulated = 0;
        foreach($detail as $element){
            $quantity_accumulated += $element['cantidad_kg'];
        }
        $quantity_accumulated += $request->input('cantidad_kg');
        return $contract['kilos'] >= $quantity_accumulated  ? 
            response()->json(['Status' => 'Success', 'Value' => $this->insert_order($request->all(),$contract)]) : 
            response()->json(['Status' => 'Error', 'Value' => 'Valor no debe sobre pasar los '.$contract['kilos'].' kilos']);        
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
            $product = Producto::where('id', $detail['id_producto'])->first(); 
            $element_array_insert = (object) array('Encabezado'=>$element,'Detalle'=>$detail,'Producto'=>$product);
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
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
    private function insert_order($data){
        $detail = new Detalle;
        $contract = Contrato::where('id',$data['id'])->first();
        $header = new Encabezado;
        //@italo: Header Insert
        $header->id_cliente = $data['id_cliente'];
        $header->f_entrega_deseada = new Carbon($data['f_entrega_deseada']);
        $header->f_creacion = Carbon::now();
        $header->save();
        //@italo: Detail Insert
        $detail->id_pedido = $header->id;
        $detail->id_producto = $data['id_producto'];
        $detail->cantidad_kg = $data['cantidad_kg'];
        $detail->save();
        return 'Register Done';
    }
}
