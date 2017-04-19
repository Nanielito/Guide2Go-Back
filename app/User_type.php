<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    public function store(Request $request)
    {
        
        $user_type = new user_type;

        $user_type->type = $request->type;

        $user_type->save();
 
    }

}
