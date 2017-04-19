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
}
