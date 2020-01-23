<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contrato;
use App\ContratoProducto;
use App\Producto;
use App\Detalle;
use App\Encabezado;
use App\Reserva;
use App\Naviera;
use Carbon\Carbon;

class OrderController extends Controller
{
    /*@italo: Registro de Contratos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*
    {
        "f_entrega_deseada":"11-12-2019",
        "id_producto":1,
        "cantidad_kg": 10,
        "cliente_id":1,
        "costo":200
    }
    */ 
    public function create(Request $request)
    {   
        $contract_user = Contrato::where('cliente_id',$request->input('cliente_id'))->orderBy('id', 'asc')->get();
        foreach ($contract_user as $key => $value) {
            $aux = ContratoProducto::where([
                ['id_contrato','=',$value['id']],
                ['id_producto','=',$request->input('id_producto')]
            ])->first();
            if(!empty($aux)){
                $contract = $aux;
                break;
            }
        }
        $quantity_accumulated = 0;
        if(isset($contract)){
            $header = Encabezado::where('cliente_id',$request->input('cliente_id'))->get();        
            
            foreach($header as $element){
                $detail = Detalle::where([
                    ['id_pedido','=',$element['id']],
                    ['id_producto','=',$request->input('id_producto')]
                ])->first();
                if(!empty($detail)){
                    $quantity_accumulated += $detail['cantidad_kg'];
                }            
            }
            $quantity_accumulated += $request->input('cantidad_kg');
        }else{
            $contract['kilos'] = 1;   
        }        
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
    public function show_client(Request $request)
    {   
        $header = Encabezado::where('cliente_id',$request->route('id'))->get();
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
    public function restrict_show_all(Request $request)
    {
        $header = Encabezado::all();
        $response = array();
        foreach($header as $element){
            $detail = Detalle::where('id_pedido', $element['id'])->first();
            $product = Producto::where('id', $detail['id_producto'])->first();
             $element['autorizado'] == 1 ? $object = (object) array('Encabezado'=>$element,'Detalle'=>$detail,'Producto'=>$product) :
             $object = (object) array('Encabezado'=>$element);
            $element_array_insert = $object;
            array_push($response,$element_array_insert);
            unset($contract_product); unset($product);
        }
        return response()->json(['Status' => 'Success', 'Value' => $response]);    
    }
    public function all_order(Request $request)
    {   
        $header = Encabezado::all();
        $response = array();
        foreach($header as $element){
            $detail = Detalle::where('id_pedido', $element['id'])->first();
            $product = Producto::where('id', $detail['id_producto'])->first();
            $reserva = Reserva::where('id', $element['reserva'])->first();
            $naviera = Naviera::where('id', $reserva['id_naviera'])->first(); 
            $element_array_insert = (object) array('Encabezado'=>$element,'Detalle'=>$detail,'Producto'=>$product,'Naviera'=>$naviera);
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
    public function detail_update(Request $request)
    {
        $data_request = $request->all();
        $detail = Detalle::where('id',$request->route('id'))->update($data_request);
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
    private function insert_order($data,$contract){
        $detail = new Detalle;
        $header = new Encabezado;
        //@italo: Header Insert
        $header->cliente_id = $data['cliente_id'];
        $header->f_entrega_deseada = new Carbon($data['f_entrega_deseada']);
        $header->f_creacion = Carbon::now();
        $header->save();
        //@italo: Detail Insert
        $detail->id_pedido = $header->id;
        $detail->id_producto = $data['id_producto'];
        $detail->cantidad_kg = $data['cantidad_kg'];
        $detail->costo = $data['costo'];
        $detail->save();
        return 'Register Done';
    }
}
