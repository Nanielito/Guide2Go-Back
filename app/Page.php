<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	public static function store($name) {

		$page = new Page;
		$page->name = $name;
		$page->save();

	}

	public function user()
	{
		return $this->hasMany('App\User','pages_id');
	}
}
