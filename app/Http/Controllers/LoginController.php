<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function validationGuide(Request $request)
    {
    	$users = \App\User::with('page')
    			->get()->where('email',$request->email)
    			->where('page.name','Guide2Go')->first();
    	if(!empty($user))
    	{
    		if($user->password == Hash::make($request->password))
    		{
    			return tokenCreation($user->id);
    		}
    		else
    		{
    			$statusCode = 401;
            	$response = [
              		'error'  => "Contraseña Incorrecta"
            	];
    		}
    	}
    	else
    	{
    		$statusCode = 401;
        	$response = [
          		'error'  => "Correo incorrecto"
        	];
    	}
    	return \Response::json($response, $statusCode);
    }

    public function tokenCreation($id)
    {
    	$payload = JWTFactory::sub($id)->make();
		$token = JWTAuth::encode($payload);
		$statusCode = 200;

		return \Response::json(compact('token'),$statusCode);
    }
}
