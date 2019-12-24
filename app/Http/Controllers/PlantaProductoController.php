<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PlantaProducto;
use App\Producto;
use App\Planta;
use Carbon\Carbon;

class PlantaProductoController extends Controller
{
    /*@italo: Registro de Plantas con productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*[
	{
		"id_planta":1,
		"id_producto":1,
		"date_desde":"12-12-2019",
		"date_hasta":"13-12-2019",
		"cantidad_kg":100
	},
	{
		"id_planta":1,
		"id_producto":2,
		"date_desde":"12-12-2019",
		"date_hasta":"13-12-2019",
		"cantidad_kg":100
	}
] */ 
    /*  Crea una relacion de la planta con un producto   */
    public function create(Request $request){
        $data_request = $request->all();
        foreach ($data_request as $key => $value) {
            $plant_producto  = new PlantaProducto;
            $plant_producto->id_producto = $value['id_producto'];
            $plant_producto->id_planta = $value['id_planta'];
            $plant_producto->cantidad_kg = $value['cantidad_kg'];
            $plant_producto->date_desde = new Carbon($value['date_desde']);
            $plant_producto->date_hasta = new Carbon($value['date_hasta']);
            $plant_producto->save();
        }                
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Creado']);        
    }
    /*@italo: Solicitud de PlantaProducto*/
    public function show(Request $request)
    {
        $plant_producto = PlantaProducto::where('id',$request->route('id'))->first();
        return response()->json(['Status' => 'Success', 'Value' => $plant_producto]);
    }
    /*@italo: Solicitud de todos los ContratosProductos*/
    public function show_all(Request $request)
    {   
        $plant_producto = PlantaProducto::all();
        return response()->json(['Status' => 'Success', 'Value' => $plant_producto]);
    }
    /*@italo: Actulizacion de Contratos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
		"id_planta":3,
		"id_producto":1,
		"date_desde":"12-12-2019",
		"date_hasta":"13-12-2019",
		"cantidad_kg":100
	} */ 
    public function update(Request $request)
    {
        $data_request = $request->all();        
        if(isset($data_request)){   //Actualizacion al contrato, de solicitarse
            $plant_producto  = new PlantaProducto;
            $plant_producto->where('id', $request->route('id'))->update($data_request);            
        }
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);           
    }
    public function destroy(Request $request)
    {
        $plant_producto  = new PlantaProducto;
        $plant_producto->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value'  => 'Registro Eliminado']);        
    }    
    /*  Te da en funcion del id del contrato, los productos asociaciados al mismo */
    public function show_plant_product(Request $request){
        $plant = Planta::where('id',$request->route('id'))->first();
        $plant_producto = PlantaProducto::where('id_planta',$request->route('id'))->get();        
        $product_array = array();
        foreach($plant_producto as $element){
            array_push($product_array,$element['id_producto']);
        }
        $product = Producto::find($product_array);
        foreach ($product as $key => $value) {
            foreach ($plant_producto as $key2 => $value2) {
                if($value2['id_producto'] == $value['id']){
                    $product[$key]['cantidad_kg'] =$value2['cantidad_kg'];
                }
            }
        }      
        $response = (object) array('plantas'=>$plant,'producto'=>$product);
        return response()->json(['Status' => 'Success', 'Value' =>$response]);
    }
    /*  Te da en funcion del id del productos, las plantas asociaciadas al mismo */
    public function show_product_plant(Request $request){
        $product = Producto::where('id',$request->route('id'))->first();
        $plant_producto = PlantaProducto::where('id_producto',$request->route('id'))->get();        
        $plant_array = array();
        foreach($plant_producto as $element){
            array_push($plant_array,$element['id_planta']);
        }
        $plant = Planta::find($plant_array);
        foreach ($plant as $key => $value) {
            foreach ($plant_producto as $key2 => $value2) {
                if($value2['id_planta'] == $value['id']){
                    $plant[$key]['cantidad_kg'] =$value2['cantidad_kg'];
                }
            }
        }      
        $response = (object) array('producto'=>$product,'plantas'=>$plant);
        return response()->json(['Status' => 'Success', 'Value' =>$response]);
    }
}
