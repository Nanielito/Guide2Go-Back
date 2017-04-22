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
}
