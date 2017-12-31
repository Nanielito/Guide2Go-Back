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

Route::post('/login/google', 'LoginController@validateGoogle')
	->middleware('cors');

/* Users */
Route::group(['middleware' => 'cors'], function() {

	Route::post('user/guia/admin', 'UserController@guiaLinkAdmin');	
	Route::post('user/guia', 'UserController@guiaLink');
	Route::post('user/admin', 'UserController@adminStore');
	Route::post('user/blogger', 'UserController@bloggerStore');

	// Shitty
	Route::post('user/facebook', 'UserController@facebookStore');
	Route::post('user/gmail', 'UserController@gmailStore'); // This shit

	Route::resource('user', 'UserController', [
		'only' => ['show', 'store' , 'update', 'destroy', 'index'], 
		'parameters' => ['user' => 'id']
	]);
});

Route::get('tokenexp', 'UserController@tokenexp');

/*Se obtienen todas las subzonas correspondientes a una zona*/
Route::get('sub_zone/zone/{id}', 'SubZoneController@subZoneZone');

Route::get('audio/parada/{id}', 'AudioController@paradaShow');

Route::get('photo/parada/{id}', 'PhotoController@paradaShow');

/*se obtienen todas las paradas correspondientes a una subzona*/
Route::get('parada/sub_zone/{id}', 'ParadaController@paradaSubZone');

/* Zonas */
Route::resource('zona', 'ZoneController');

/* ############################################################################ */
/* # Guias                                                                    # */
/* ############################################################################ */
Route::resource('guia', 'GuideController');

//http://URL/api/guides
//http://URL/api/guides?language=1&zone=42
//http://URL/api/guides?language=1
//http://URL/api/guides?zone=42
Route::get('guides', 'GuideController@getGuides');

//http://URL/api/guides/80/-62/1
//http://URL/api/guides/80/-62/1?language=1
Route::get('guides/{latitude}/{longitude}/{radius}', 'GuideController@getGuidesByPosition');

Route::get('guides/{id}', 'GuideController@getGuide');
/* ############################################################################ */

/* Paradas */
Route::resource('parada', 'ParadaController');

/* Sub Zonas */
Route::resource('sub_zone', 'SubZoneController');

/* Audio */
Route::resource('audio', 'AudioController');

/*Photo*/
Route::resource('photo', 'PhotoController');

/*Idioma*/
Route::resource('idioma', 'IdiomaController');
