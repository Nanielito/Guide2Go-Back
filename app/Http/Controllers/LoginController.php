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
				return $this->tokenCreation($user->id,$user->user_types_id,$user->name,$user->dolares);
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

	public function tokenCreation($id,$type,$name,$dolares)
	{
		$customClaims = ['sub' => $id, 'user_type' => $type, 'name' => $name];

		$payload = \JWTFactory::make($customClaims);

		$token = \JWTAuth::encode($payload)->get();


		//$payload = \JWTFactory::sub($id)->make();
		//$token = \JWTAuth::encode($payload)->get();
		$statusCode = 200;

		return \Response::json(compact('token'),$statusCode);
	}
}
