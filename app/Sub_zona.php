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
}
