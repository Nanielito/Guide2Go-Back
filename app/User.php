<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_types_id', 'pages_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_type()
    {
        return $this->belongsTo('App\User_type', 'user_types_id');
    }

    public function page()
    {
        return $this->belongsTo('App\Page', 'pages_id');
	}

	public function guias() {
		return $this->belongsToMany('App\Guia', 'user_guide', 'user_id', 'guide_id');
	}
}

