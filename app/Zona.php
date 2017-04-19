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
    	return $this->hasMany('App\Guia');
    }
}
