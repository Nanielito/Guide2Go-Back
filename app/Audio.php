<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
	protected $table = "audios";

	public function parada() {
		return $this->belongsTo('App\Parada', 'parada_id');
	}

	/**
	 * Guarda un nuevo audio en la base de datos
	 * @param  array $args
	 * @return Audio
	 */
	public static function store($args) {
		
		$aud = new Audio;
		$aud->parada_id  = $args['spot'];
		$aud->idiomas_id = $args['lang'];
		$aud->path       = $args['path'];
		$aud->save();

		return $aud;
	}
}
