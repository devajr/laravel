<?php

use App\Cliente;
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
// Route::middleware('auth:api')->get('/cliente', function (Request $request) {
//     return response()->json(Cliente::all());
// });
//Route::get('/cliente', 'ClienteController@getAll');
Route::group([
    'middleware' => 'auth:api',
    'prefix'    =>  'cliente'
], function(){
   Route::get('', 'ClienteController@getAll');
   Route::get('edit/{id}', 'ClienteController@edit');
   Route::post('create', 'ClienteController@create');
   Route::post('update', 'ClienteController@update');
   Route::delete('{id}', 'ClienteController@destroy');
});
//Route::prefix('auth')->group(function(){
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('getUser', 'AuthController@getUser');
    Route::get('logout', 'AuthController@logout');
});
//});