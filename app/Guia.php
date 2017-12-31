<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
	public function zona() {
		return $this->belongsTo('App\Zona', 'zonas_id');
	}

	public function users() {
		return $this->belongsToMany('App\User', 'user_guide', 'guide_id', 'user_id');
	}

	public function idiomas() {
		return $this->belongsTo('App\Idioma', 'idiomas_id');
	}

	public static function createGuia($parameters) {
		$guide = new Guia;

		$guide->zonas_id    = $parameters['zone'];
		$guide->idiomas_id  = $parameters['lang'];
		$guide->nombre      = $parameters['name'];
		$guide->descripcion = $parameters['description'];
		$guide->costo       = $parameters['cost'];

		return $guide->save() ? $guide : null;
	}

	public static function updateGuia($id, $parameters) {
        $guide = Guia::find($id);

        if (isset($guide)) {
            $guide->zonas_id    = $parameters['zone'];
            $guide->idiomas_id  = $parameters['lang'];
            $guide->nombre      = $parameters['name'];
            $guide->descripcion = $parameters['description'];
            $guide->costo       = $parameters['cost'];

            $guide->update();
        }

        return $guide;
    }
}

