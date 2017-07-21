<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Helpers\JWTHelper;
use \App\Guia;
use \APp\User;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
	{
		// Retorna un usuario del token
		// si existe
		$fromUser = JWTHelper::authenticate();
		if (!$fromUser) {
			$response = [ 'error' => "No se encontro token" ];
			return \Response::json($response, 403);
		}

		// Obtiene un usuario del request
		$userId = $request->self;

		if (empty($userId)) {
			$response = [
                		'guides'  => []
            		]; 
			$guias = Guia::all();
			foreach($guias as $guide){
				$zonaNombre= \App\Zona::find($guide->zonas_id)->name;				
				$idioma = \App\Idioma::find($guide->idiomas_id)->name;
                        	$response['guides'][] = [
                            	'id' => $guide->id,
                            	'name' => $zonaNombre,
                            	'costo' => $guide->costo,
                            	'idioma' => $idioma,
                            	'zonas_id' => $guide->zonas_id,
                            	'idiomas_id' => $guide->idiomas_id
                        	];
                    	}

			return $response;
		}
		
		// Verifica que el usuario que hace el 
		// request puede ver las guias 
		/*if ($fromUser->id != $userId && 
			$fromUser->user_types_id != 1 ) { // Admin 
			 
			$response = [ 'error' => "No autorizado" ];
			return \Response::json($response, 403);
		}*/

		// Trae las guias del usuario

		$userGuides = User::where('id',$fromUser->id)->getRelation('guias')->where('user_id',$fromUser->id)->with('zona')->get();

		return $userGuides;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$params = [
			'zone' => $request->zone,
			'lang' => $request->lang,
			'cost' => $request->cost,
		];

		// Crea una guia en la base de datos
		$guide = Guia::store($params);

		$response = $guide->jsonSerialize();
		return \Response::json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
	if(\JWTAuth::getToken()){
            $response = [
                "respuesta" => "Actualizado con exito"
            ];
            $statusCode = 200;
            $guide = \App\Guia::find($id);

            $guide->zonas_id = $request->zone;
            $guide->idiomas_id = $request->lang;
            $guide->costo = $request->cost;
            $guide->save();
        }
        else{
            $response = [
                "error" => "Sin Autorizacion"
            ];
            $statusCode = 403;
        }
        return \Response::json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
