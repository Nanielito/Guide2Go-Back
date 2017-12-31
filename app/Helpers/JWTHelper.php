<?php

namespace App\Helpers;

use Tymon\JWTAuth\Exceptions\JWTException;

class JWTHelper {

	public static function fromUserType($type) {
		$user = self::authenticate();

		return $user
			? $user->user_types_id == $type
			: false;
	}

	public static function authenticate() {
		$user = null;

		try {
			if (\JWTAuth::getToken()) {
				$token = \JWTAuth::parseToken();
				$user = $token->authenticate();
			}
		}
		catch (JWTException $ex) {
			throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
		}

		return $user;
	}
}
