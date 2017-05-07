<?php

namespace App;

use ElevenLab\GeoLaravel\Eloquent\Model as GeoModel;

class Parada extends GeoModel
{
    protected $geometries = [
    	'points' => ['punto']
    ];

    public function subZona() {
    	return $this->belongsTo('App\Sub_zona', 'sub_zonas_id');
	}

	public function audios() {
	   return $this->hasMany('App\Audio', 'parada_id');	
	}
	
	/**
	 * Crear una parada en la base de datos
	 *
	 * @param  array 
	 * @return Parada
	 */
	public static function store($args) {
		
		$stop = new Parada;
		$stop->sub_zonas_id = $args['subzone'];
		$stop->categoria_id = $args['category'];
		$stop->nombre = $args['name'];
		$stop->descripcion = $args['description'];
		$stop->punto = $args['point'];
		$stop->save();

		return $stop;
	}
}
