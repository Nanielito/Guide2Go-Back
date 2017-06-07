<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use ElevenLab\PHPOGC\DataTypes\Polygon as Polygon;
use \App\Helpers\JWTHelper;
use \App\Zona;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
	{
        //helper no funciona ver despues por que
		//if (JWTHelper::authenticate() == null) {
        if(!\JWTAuth::getToken()){
			$response = ['error' => 'Unauthorized' ];
            return \Response::json($response, 403);   
		}
        return Zona::all(); 
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
		// Verifica si es un admin
		if (!JWTHelper::fromUserType(1)) {
			$response = [ 'error' => "No autorizado" ];
			return \Response::json($response, 403);
		}

		// Pude haber usado el metodo input
		// pero tendria que especificar que 
		// el request es json siempre...
		$json = $request->json()->all();
		$poly = $json['polygon']; 
		$name = $json['name'];

		// Guarda la zona en la base de datos
		// El poligono viene como [ [x, y], ..., [x, y] ]
		$zone = Zona::store([
			'name' => $name,
			'polygon' => Polygon::fromArray([$poly])
		]);

		$response = $zone->jsonSerialize();
		
		// Podria hacer una funcion que autocompleta
		// el poligono si no es circular, pero no...
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
