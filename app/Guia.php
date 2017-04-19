<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    public function zona() {
    	return $this->belongsTo('App\Zona');
    }
}
