<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use ElevenLab\PHPOGC\DataTypes\Polygon as Polygon;
use \App\Helpers\JWTHelper;
use \App\Sub_zona;

class SubZoneController extends Controller
{


    public function subZoneZone($id)
    {
        return Sub_zona::all()->where('zonas_id',$id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sub_zona::with('zona')->get();
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

		$json = $request->json()->all();
		$zone = $json['zone'];
		$name = $json['name'];
		$poly = $json['polygon'];

		// Guarda la sub zona en la base de datos
		$subz = Sub_zona::store([
			'zone' => $zone,
			'name' => $name,
			'polygon' => Polygon::fromArray([$poly])
		]);

		$response = $subz->jsonSerialize();
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
        $statusCode = 200;
        $subZona = Sub_zona::find($id);

        if(!empty($request->name)) $subZona->nombre = $request->name;
        if(!empty($request->polygon)) $subZona->poligono = Polygon::fromArray([$request->polygon]);
	if(!empty($request->zone)) $subZona->zonas_id = $request->zone;
        $subZona->save();

        return \Response::json($subZona, $statusCode);
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
            //
    }
}
