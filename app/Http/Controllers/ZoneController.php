<?php

namespace App\Http\Controllers;

use \App\Zona;
use Illuminate\Http\Request;

use ElevenLab\PHPOGC\DataTypes\Point as Point;
use ElevenLab\PHPOGC\DataTypes\Polygon as Polygon;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
		// Pude haber usado el metodo input
		// pero tendria que especificar que 
		// el request es json siempre...
		$request = $request->json()->all();
		$polygon = $request['polygon']; 
		$name    = $request['name'];

		// Guarda la zona en la base de datos
		// El poligono viene como [ [x, y], ..., [x, y] ]
		$zone = Zona::store(
			$name, Polygon::fromArray([$polygon])
		);

		$response = [
			'id' => $zone->id,
			'polygon' => [$polygon],
			'name' => $name,
			'created_at' => $zone->created_at,
		];
		
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
