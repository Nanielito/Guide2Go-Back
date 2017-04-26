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

/* Login */
Route::post('/login','LoginController@validationGuide')
	->middleware('cors');

/* Users */

Route::resource('user', 'UserController', [
		'only' => ['show', 'store' , 'update', 'destroy', 'index'], 
		'parameters' => ['user' => 'id']
	]
);

/* Zonas */
Route::resource('zona', 'ZoneController');

/* Guias */
Route::resource('guia', 'GuideController');

/* Paradas */
Route::resource('parada', 'ParadaController');

/* Sub Zonas */
Route::resource('sub_zone', 'SubZoneController');
