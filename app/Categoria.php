<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria_paradas';

    public static function store($name) {

    	$cat = new Categoria;
    	$cat->nombre = $name;
    	$cat->save();

    }
}
