<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	private $client_id;

	public function __construct() {
		$this->client_id = Config::get('google.client_id');
	}

	public function validationGuide(Request $request)
	{
		$user = \App\User::with('page')
			->get()->where('email',$request->email)
			->where('page.name','Guide2Go')->first();

		if(!empty($user))
		{

			if(\Hash::check($request->password, $user->password))
			{
				return $this->tokenCreation($user);
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

	private function tokenCreation($user)
	{
		$customClaims = [
			'sub' => $user->id, 
			'user_type' => $user->type,
			'name' => $user->name
		];

		//$payload = \JWTFactory::sub($id)->make();
		$payload = \JWTFactory::make($customClaims);
		$token = \JWTAuth::encode($payload)->get();

		$statusCode = 200;

		return \Response::json(compact('token'), $statusCode);
	}

	/**
	 * Verifica un token de google
	 * Recibe un token y un referer_id (opcional)
	 */
	public function validateGoogle(Request $request) {

		$id_token = $request->token;

		if (empty($id_token)) {
			$statusCode = 400;
			$response = [
				'respuesta' => "Falto proveer un token"
			];
			return \Response::json($response, $statusCode);
		}

		// Verifica el token de Google
		$client = new \Google_Client(['client_id' => $this->client_id]);
		$payload = $client->verifyIdToken($id_token);

		if (!$payload) {
			$statusCode = 400;
			$response = [
				'respuesta' => "Token invalido"
			];
			return \Response::json($response, $statusCode);
		} 

		// No requerido (Creo)	
		// $userid = $payload['sub'];
		
		if (!array_has($payload, ['email', 'name'])) {
			$statusCode = 400;
			$response = [
				'respuesta' => "El token no contiene email y nombre"
			]
			return \Response::json($response, $statusCode);
		}

		$email = $payload['email'];
		$name = $payload['name'];

		// Ineficiente?
		$user = \App\User::all()
			->where('email',$email)
			->where('pages_id','3')
			->first();

		if (empty($user)) {
			$referer_id = $request->referer_id;
			$user = \App\User::googleStore(
				compact('email', 'name', 'referer_id')
			);
		}

		return $this->tokenCreation($user);
	}
}
