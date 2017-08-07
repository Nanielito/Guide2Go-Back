<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
	public static function store($name) {

		$lang = new Idioma();
		$lang->name = $name;
		$lang->save();

	}
}
