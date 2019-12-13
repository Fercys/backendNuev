<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductoUsuario;
use App\User;
use App\Producto;

class ProductoUsersController extends Controller
{
    /*@italo: Registro de Productos*/
    /* Estructura de ejemplo, todos los campos son requeridos */
    /*{
        "id_producto":1,
        "id_users":2
    } */ 
    /*  Relaciona un usuario con un producto    */
    public function create(Request $request){
        $producto_users  = new ProductoUsuario;
        $producto_users->id_producto = $request->input('id_producto');
        $producto_users->id_users = $request->input('id_users');        
        $producto_users->save();
        return response()->json(['Status' => 'Success', 'Value' => 'Registro Creado']);        
    }    
    /*  Te da en funcion del id del productos, los usuarios asociaciados al mismo */
    public function show_product_user(Request $request){
        $producto = Producto::where('id',$request->route('id'))->first();
        $producto_users = ProductoUsuario::where('id_producto',$request->route('id'))->get();        
        $user_array = array();
        foreach($producto_users as $element){
            array_push($user_array,$element['id_users']);
        }
        $user = User::find($user_array);      
        $response = (object) array('producto'=>$producto,'usuarios'=>$user);
        return response()->json(['Status' => 'Success', 'Value' =>$response]);
    }
    /*  Te da en funcion del id del usuario, los productos asociaciados al mismo */
    public function show_user_product(Request $request){
        $user = User::where('id',$request->route('id'))->first();
        $producto_users = ProductoUsuario::where('id_users',$request->route('id'))->get();        
        $product_array = array();
        foreach($producto_users as $element){
            array_push($product_array,$element['id_producto']);
        }
        $product = Producto::find($product_array);      
        $response = (object) array('usuario'=>$user,'productos'=>$product);
        return response()->json(['Status' => 'Success', 'Value' =>$response]);
    }     
}
