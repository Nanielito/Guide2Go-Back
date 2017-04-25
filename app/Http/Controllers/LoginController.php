<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function validationGuide(Request $request)
    {
    	$user = \App\User::with('page')
    			->get()->where('email',$request->email)
    			->where('page.name','Guide2Go')->first();

    	if(!empty($user))
    	{

    		if(\Hash::check($request->password, $user->password))
    		{
    			return $this->tokenCreation($user->id);
    		}
    		else
    		{
    			$statusCode = 401;
            	$response = [
              		'error'  => "Contrasenha Incorrecta"
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
    	$payload = \JWTFactory::sub($id)->make();
		$token = \JWTAuth::encode($payload)->get();
		$statusCode = 200;

		return \Response::json(compact('token'),$statusCode);
    }
}
