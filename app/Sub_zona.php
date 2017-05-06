<?php

namespace App;

use ElevenLab\GeoLaravel\Eloquent\Model as GeoModel;

class Sub_zona extends GeoModel
{
    protected $geometries = [

    	"polygons" => ['poligono']
    
    ];

    public function paradas() {
    	return $this->hasMany('App\Parada', 'sub_zonas_id');
	}

	/**
	 * Guarda en la base de datos una sub zona
	 *
	 * @param  array $args : ['zone', 'name', 'polygon']
	 * @return Zona
	 */
	public static function store($args) {
		
		$subz = new Sub_zona;
		$subz->zonas_id = $args['zone'];
		$subz->nombre = $args['name'];
		$subz->poligono = $args['polygon'];
		$subz->save();

		return $subz;
	}
}
