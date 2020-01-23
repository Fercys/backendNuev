<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Contratos 
Route::get('/contract/{id}', 'ContractController@show');
Route::get('/contract', 'ContractController@show_all');
Route::post('contract', 'ContractController@create');
Route::put('/contract/{id}', 'ContractController@update');
Route::delete('/contract/{id}', 'ContractController@destroy');
// Contratos Productos
Route::get('contract_product/{id}', 'ContratoProductoController@show');
Route::get('contract_product', 'ContratoProductoController@show_all');
Route::post('contract_product', 'ContratoProductoController@create');
Route::put('/contract_product/{id}', 'ContratoProductoController@update');
Route::delete('/contract_product/{id}', 'ContratoProductoController@destroy');

Route::get('/contract_product/contract/{id}', 'ContratoProductoController@show_contract_product');
Route::get('/contract_product/product/{id}', 'ContratoProductoController@show_product_contract');
//Ordenes
Route::get('/order/{id}', 'OrderController@show');
Route::get('/order', 'OrderController@show_all');
Route::get('/order/client/{id}', 'OrderController@show_client');
Route::get('/order_restrict', 'OrderController@restrict_show_all');
Route::post('/order', 'OrderController@create');
Route::put('/order/{id}', 'OrderController@update');
Route::put('/order/detail/{id}', 'OrderController@detail_update');
Route::delete('/order/{id}', 'OrderController@destroy');
//Productos
Route::get('/product/{id}', 'ProductoController@show');
Route::get('/product', 'ProductoController@show_all');
Route::post('/product', 'ProductoController@create');
Route::put('/product/{id}', 'ProductoController@update');
Route::delete('/product/{id}', 'ProductoController@destroy');
// Productos User
Route::get('/product_users/users/{id}', 'ProductoUsersController@show_user_product');
Route::get('/product_users/product/{id}', 'ProductoUsersController@show_product_user');
Route::post('/product_users', 'ProductoUsersController@create');
//Plantas
Route::get('/plant/{id}', 'PlantaController@show');
Route::get('/plant', 'PlantaController@show_all');
Route::post('/plant', 'PlantaController@create');
Route::put('/plant/{id}', 'PlantaController@update');
Route::delete('/plant/{id}', 'PlantaController@destroy');
//Plantas Productos
Route::get('/plant_product/{id}', 'PlantaProductoController@show');
Route::get('/plant_product', 'PlantaProductoController@show_all');
Route::post('/plant_product', 'PlantaProductoController@create');
Route::put('/plant_product/{id}', 'PlantaProductoController@update');
Route::delete('/plant_product/{id}', 'PlantaProductoController@destroy');

Route::get('/plant_product/plant/{id}', 'PlantaProductoController@show_plant_product');
Route::get('/plant_product/product/{id}', 'PlantaProductoController@show_product_plant');

//Agrotop
Route::get('/agrotop/{id}', 'AgrotopController@show');
Route::get('/agrotop', 'AgrotopController@show_all');
Route::post('/agrotop', 'AgrotopController@create');
Route::put('/agrotop/{id}', 'AgrotopController@update');
Route::delete('/agrotop/{id}', 'AgrotopController@destroy');

Route::post('/agrotop_get_api', 'AgrotopController@secure');

//Puertos
Route::get('/puerto/{id}', 'PuertosController@show');
Route::get('/puerto', 'PuertosController@show_all');
Route::post('/puerto', 'PuertosController@create');
Route::put('/puerto/{id}', 'PuertosController@update');
Route::delete('/puerto/{id}', 'PuertosController@destroy');

//Navieras
Route::get('/naviera/{id}', 'NavierasController@show');
Route::get('/naviera', 'NavierasController@show_all');
Route::post('/naviera', 'NavierasController@create');
Route::put('/naviera/{id}', 'NavierasController@update');
Route::delete('/naviera/{id}', 'NavierasController@destroy');

//Puertos Navieras
Route::get('/naviera_puerto/{id}', 'PuertosNavierasController@show');
Route::get('/naviera_puerto', 'PuertosNavierasController@show_all');
Route::post('/naviera_puerto', 'PuertosNavierasController@create');
Route::put('/naviera_puerto/{id}', 'PuertosNavierasController@update');
Route::delete('/naviera_puerto/{id}', 'PuertosNavierasController@destroy');

//Proformas
Route::get('/proforma/{id}', 'ProformaController@show');
Route::get('/proforma', 'ProformaController@show_all');
Route::post('/proforma', 'ProformaController@create');
Route::put('/proforma/{id}', 'ProformaController@update');
Route::delete('/proforma/{id}', 'ProformaController@destroy');
