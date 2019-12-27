<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PlantaProducto;
use App\Producto;
use App\Planta;
use Carbon\Carbon;
use App\Http\Resources\plantaproductocollection;

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
        $validate_date_range = $this->compare_date($data_request);
        if($validate_date_range != false){
           return $validate_date_range; 
        }
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
        $plant_producto['date_desde'] = Carbon::parse($plant_producto['date_desde'])->format('d/m/Y');
        $plant_producto['date_hasta'] = Carbon::parse($plant_producto['date_hasta'])->format('d/m/Y');
        return response()->json(['Status' => 'Success', 'Value' => $plant_producto]);
    }
    /*@italo: Solicitud de todos las PlantaProductos*/
    public function show_all(Request $request)
    {   
        $plant_producto = PlantaProducto::all();
        /*test */        
        //return response()->json(['Status' => 'Success', 'Value' => plantaproductocollection::collection($plant_producto)]);
        foreach ($plant_producto as $key => $value) {
            $plant_producto[$key]['producto'] = Producto::find($value['id_producto']);
            $plant_producto[$key]['planta'] = Producto::find($value['id_planta']);
        }
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
        if(isset($data_request)){
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
    private function compare_date($data_request,$id = null){
        foreach ($data_request as $key => $value) {
            $plant_producto_compare  = PlantaProducto::where(['id_producto'=>$value['id_producto'],'id_planta'=>$value['id_planta']])->get();
            if(count($plant_producto_compare) != 0){
                $date_desde_request = Carbon::create($value['date_desde']);
                $date_hasta_request = Carbon::create($value['date_hasta']);               
                foreach ($plant_producto_compare as $key2 => $value2) {
                    $date_desde_db = Carbon::create($value2['date_desde']);
                    $date_hasta_db = Carbon::create($value2['date_hasta']);
                    if($date_desde_db->lessThanOrEqualTo($date_desde_request) && $date_hasta_db->greaterThanOrEqualTo($date_desde_request)){
                        $response = 'No se puede ingresar una fecha dentro del rango ingresado. Intervalo: '.$value2['date_desde'].' - '.$value2['date_hasta'].' Fecha ingresada: '.$value['date_desde'];
                        return response()->json(['Status' => 'Error', 'Value' => $response]);
                    }
                    if($date_desde_db->lessThanOrEqualTo($date_hasta_request) && $date_hasta_db->greaterThanOrEqualTo($date_hasta_request)){
                        $response = 'No se puede ingresar una fecha dentro del rango ingresado. Intervalo: '.$value2['date_desde'].' - '.$value2['date_hasta'].' Fecha ingresada: '.$value['date_hasta'];
                        return response()->json(['Status' => 'Error', 'Value' => $response]);
                    }
                    if($date_desde_request->lessThanOrEqualTo($date_desde_db) && $date_hasta_request->greaterThanOrEqualTo($date_hasta_db)){
                        $response = 'No se puede ingresar una fecha dentro del rango ingresado. Intervalo: '.$value2['date_desde'].' - '.$value2['date_hasta'].' Fecha ingresada inferior: '.$value['date_desde'].' Fecha ingresada superior: '.$value['date_hasta'];
                        return response()->json(['Status' => 'Error', 'Value' => $response]);
                    }                         
                }
            }
        }
        return false;                  
    }
}
