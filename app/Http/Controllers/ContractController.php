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
    public function register(Request $request)
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
            foreach($data_request['product'] as $element){
                $product  = new Producto;
                $contract_product = new ContratoProducto;
                $product->kilos = $element['kilo'];
                $product->save();
                $contract_product->id_producto = $product->id;
                $contract_product->id_contrato = $contract->id; 
                $contract_product->save();
                unset($product);unset($contract_product);
            }                        
        }catch(Exception $e){
            return response()->json(['Status' => 'Error', 'Value' => $e]);
        }        
        return response()->json(['Status' => 'Success', 'Value' => 'Register Done']);
    }
    public function order(Request $request)
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
    private function insert_order($data,$contract_product){
        $detail = new Detalle;
        $contract = Contrato::where('id',$data['id'])->first();
        $header = new Encabezado;
        //@italo: Header Insert
        $header->id_cliente = $contract['id_cliente'];
        $header->f_entrega_deseada = new Carbon($data['date_estimate']);
        $header->f_creacion = Carbon::now();
        $header->save();
        //@italo: Detail Insert
        $detail->id_pedido = $header->id;
        $detail->id_producto = $contract_product['id_producto'];
        $detail->cantidad_kg = $data['quantity'];
        $detail->save();
        return 'Register Done';
    }
}
