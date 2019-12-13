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
//Ordenes
Route::get('/order/{id}', 'OrderController@show');
Route::get('/order', 'OrderController@show_all');
Route::post('/order', 'OrderController@create');
Route::put('/order/{id}', 'OrderController@update');
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
