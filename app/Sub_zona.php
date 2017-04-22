<?php

namespace App;

use ElevenLab\GeoLaravel\Eloquent\Model as GeoModel;

class Sub_zona extends GeoModel
{
    protected $geometries = [

    	"polygons" => ['poligono']
    
    ];
}
