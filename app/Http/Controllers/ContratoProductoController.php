<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contrato;
use App\ContratoProducto;
use App\Producto;
use App\ProductoUsuario;
use App\User;
use Carbon\Carbon;

class ContratoProductoController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{        
        "contract":{
            "f_inicio":"25-12-2019",
            "f_final":"27-12-2019",
            "id_user": 1
        },
        "contract_product":[
            {
                "id_producto":"1",
                "kilos":100
            },
            {
                "id_producto":"2",
                "kilos":20
            }
        ]
    } */ 
    /*  Crea un contrato con sus productos    */
    public function create(Request $request){
        $data_request = $request->all();
        //Agregar contrato a la base de datos
        $contract  = new Contrato;
        $contract->f_inicio = new Carbon($data_request['contract']['f_inicio']);
        $contract->f_final = new Carbon($data_request['contract']['f_final']);
        $contract->id_user = $data_request['contract']['id_user'];
        $contract->save();
        //Agrega la relacion de contrato con productos
        $register = array();
        foreach($data_request['contract_product'] as $element){
            array_push($register,array(
                "id_contrato" => $contract['id'],
                "id_producto" => $element['id_producto'],
                "kilos" => $element['kilos'],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s')
            ));
        }
        ContratoProducto::insert($register);         
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Creado']);        
    }
    /*@italo: Solicitud de ContratosProductos*/
    public function show(Request $request)
    {
        $contract_product = ContratoProducto::where('id',$request->route('id'))->first();
        return response()->json(['Status' => 'Success', 'Value' => $contract_product]);
    }
    /*@italo: Solicitud de todos los ContratosProductos*/
    public function show_all(Request $request)
    {   
        $contract = Contrato::all();
        $response = [];
        foreach ($contract as $key => $value) {
            $response[$key]['contrato'] = $value;  
            $response[$key]['usuario']= User::where('id',$value['id_user'])->get(); 
            $contract_product = ContratoProducto::where('id_contrato',$value['id'])->get();
            $response[$key]['products'] = [];
            foreach ($contract_product as $key2=>$value) {
                $response[$key]['products'][$key2] = Producto::where('id',$value['id_producto'])->first();
            }           
        }
        return response()->json(['Status' => 'Success', 'Value' => $response]);
    }
    /*@italo: Actulizacion de Contratos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "contract_product":{
            "kilos":20,
            "id_producto":1,
            "id_contrato":3
        }
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();        
        if(isset($data_request['contract_product'])){   //Actualizacion al contrato, de solicitarse
            $contract_product  = new ContratoProducto;
            $contract_product->where('id', $request->route('id'))->update($data_request['contract_product']);            
        }
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);           
    }
    public function destroy(Request $request)
    {
        $contract_product  = new ContratoProducto;
        $contract_product->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }    
    /*  Te da en funcion del id del contrato, los productos asociaciados al mismo */
    public function show_contract_product(Request $request){
        $contract = Contrato::where('id',$request->route('id'))->first();
        $contract_product = ContratoProducto::where('id_contrato',$request->route('id'))->get();        
        $product_array = array();
        foreach($contract_product as $element){
            array_push($product_array,$element['id_producto']);
        }
        $product = Producto::find($product_array);      
        $response = (object) array('contrato'=>$contract,'productos'=>$product);
        return response()->json(['Status' => 'Success', 'Value' =>$response]);
    }
    /*  Te da en funcion del id del productos, los contratos asociaciados al mismo */
    public function show_product_contract(Request $request){
        $product = Producto::where('id',$request->route('id'))->first();
        $contract_product = ContratoProducto::where('id_producto',$request->route('id'))->get();        
        $contract_array = array();
        foreach($contract_product as $element){
            array_push($contract_array,$element['id_contrato']);
        }
        $contract = Contrato::find($contract_array);      
        $response = (object) array('producto'=>$product,'contratos'=>$contract);
        return response()->json(['Status' => 'Success', 'Value' =>$response]);
    }
}
