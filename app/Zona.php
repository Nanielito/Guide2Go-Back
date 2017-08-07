<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ElevenLab\GeoLaravel\Eloquent\Model as GeoModel;

class Zona extends GeoModel
{
	protected $geometries = [

		"polygons" => ['poligono']

	];

	public function guias() {
		return $this->hasMany('App\Guia', 'zonas_id');
	}

	public function subZonas() {
		return $this->hasMany('App\Sub_zona', 'zonas_id');
	}

	/**
	 * Guarda en la base de datos una zona
	 *
	 * @param  array $args : ['name', 'polygon']
	 * @return Zona
	 */
	public static function store($args) {

		$zone = new Zona;
		$zone->name = $args['name'];
		$zone->poligono = $args['polygon'];
		$zone->save();

		return $zone;
	}
}
