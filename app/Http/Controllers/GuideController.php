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
		$userId = $request->user;
		$self   = $request->self;

		if ($self) {
			$userId = $fromUser->id;
		}
		
		// Por ahora vamos a dejar que cualquier usuario
		// pueda ver todas las guias
		// Hay que limitar la informacion aqui
		if (empty($userId)) {
			return Guia::all();
		}
	
		// Verifica que el usuario que hace el 
		// request puede ver las guias 
		if ($fromUser->id != $userId && 
			$fromUser->user_types_id != 1 ) { // Admin 
			 
			$response = [ 'error' => "No autorizado" ];
			return \Response::json($response, 403);
		}

		// Trae las guias del usuario
		$userGuides = User::query()
			->getRelation('guias')->with('zona')
			->wherePivot('user_id', '=', $userId)
			->get();

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
        //
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
