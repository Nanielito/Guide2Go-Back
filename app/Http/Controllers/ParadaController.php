<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use ElevenLab\PHPOGC\DataTypes\Point as Point;
use \App\Helpers\JWTHelper;
use \App\Parada;

class ParadaController extends Controller
{

	public function paradaSubZone($id)
	{
		return Parada::all()->where('sub_zonas_id',$id);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Parada::with('subZona')->get();
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

		$subz  = $json['subzone'];
		$catg  = $json['category'];
		$name  = $json['name'];
		$desc  = $json['description']; // Otro nombre?
		$point = $json['point'];
		$meters = $json['meters'];

		$stop = Parada::store([
			'subzone' => $subz,
			'category' => $catg,
			'name' => $name,
			'description' => $desc,
			'point' => Point::fromArray($point),
			'meters' => $meters
		]);

		$response = $stop->jsonSerialize();
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
		$parada = Parada::find($id);

		if(!empty($request->name)) $parada->nombre = $request->name;
		if(!empty($request->description)) $parada->descripcion = $request->description;
		if(!empty($request->point)) $parada->punto = Point::fromArray($request->point);
		if(!empty($request->subzone)) $parada->sub_zonas_id = $request->subzone;
		if(!empty($request->category)) $parada->categoria_id = $request->category;
		if(!empty($request->meters)) $parada->meters = $request->meters;
		$parada->save();

		return \Response::json($parada, $statusCode);
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
