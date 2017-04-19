<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function store(Request $request)
    {
        
        $page = new page;

        $page->name = $request->name;

        $page->save();
 
    }
}
