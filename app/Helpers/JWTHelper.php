<?php

namespace App\Helpers;

class JWTHelper {

	public static function fromUserType($type) {

		// Ugly skinny code
		$user = self::authenticate();

		return $user
			? $user->user_types_id == $type
			: false;	
	}

	public static function authenticate() {

		$user = null;
		if (\JWTAuth::getToken()) {
			$token = \JWTAuth::parseToken();
			$user = $token->authenticate();
		}

		return $user;	
	}

}

?>
