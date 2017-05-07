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

	public static function store($args) {

		$guide = new Guia;
		$guide->zonas_id   = $args['zone'];
		$guide->idiomas_id = $args['lang'];
		$guide->costo      = $args['cost'];
		$guide->save();

		return $guide;
	}
}
