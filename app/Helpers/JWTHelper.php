<?php

namespace App\Helpers;

class JWTHelper {

	public static function fromUserType($type) {

		if (\JWTAuth::getToken()) {
			$token = \JWTAuth::parseToken();
			$user = $token->authenticate();
			return $user->user_types_id == $type;
		}
		else { 
			return false;
		}
	}

}

?>
