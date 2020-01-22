<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Producto;
use App\Users;

class ProductoController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "detalle":"prueba"
    } */ 
    public function create(Request $request)
    {
        $producto  = new Producto;
        $producto->precio = $request->input('precio');
        $producto->detalle = $request->input('detalle');
        $producto->save();      
        return response()->json(['Status' => 'Success', 'Value' => $producto]);
    }    
    /*@italo: Solicitud de Productos*/
    public function show(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => 
            Producto::where('id',$request->route('id'))->first()]);
    }
    /*@italo: Solicitud de todos los Productos*/
    public function show_all(Request $request)
    {
        return response()->json(['Status' => 'Success', 'Value' => Producto::all()]);
    }
    /*@italo: Actulizacion de Productos*/
    /* Estructura de ejemplo, ningun campo es obligatorio */
    /*{
        "detalle":"prueba"
    } */ 
    public function update(Request $request)
    {
        $data_request = $request->all();
        $product = new Producto;
        $product->where('id', $request->route('id'))->update($data_request);
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Actualizado']);                 
    }
    public function destroy(Request $request)
    {
        $product  = new Producto;
        $product->destroy($request->route('id'));
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Eliminado']);        
    }
}
