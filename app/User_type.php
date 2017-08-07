<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
	public static function store($type)
	{
		$user_type = new User_type;
		$user_type->type = $type;
		$user_type->save();
	}

	public function user()
	{
		return $this->hasMany('App\User','user_types_id');
	}

}
