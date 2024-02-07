<?php

namespace App\Utils;

use DateTime;
use DateTimeZone;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
	public static function get_default_options(string $expire): array
	{
		$default_timezone = date_default_timezone_get();
		$now = new DateTime("now", new DateTimeZone($default_timezone));

		$iss = APP["APP_NAME"];
		$iat = $now->getTimestamp();
		$exp = $now->modify($expire)->getTimestamp();

		return [
			"iss" => $iss,
			"iat" => $iat,
			"exp" => $exp,
		];
	}

	public static function generate_refresh_token(array $payload): string
	{
		$default_options = JWTToken::get_default_options("+1 week");
		$merged_payload = array_merge(
			$default_options,
			$payload,
		);

		return JWT::encode(
			$merged_payload,
			$_ENV["SECRET_TOKEN_KEY"],
			"HS256",
		);
	}

	public static function generate_access_token(array $payload): string
	{
		$default_options = JWTToken::get_default_options("+1 hours");
		$merged_payload = array_merge(
			$default_options,
			$payload,
		);

		return JWT::encode(
			$merged_payload,
			$_ENV["SECRET_TOKEN_KEY"],
			"HS256",
		);
	}

	public static function generate_tokens(array $payload): array
	{
		$refresh_token = JWTToken::generate_refresh_token($payload);
		$access_token = JWTToken::generate_access_token($payload);

		return [
			"refresh_token" => $refresh_token,
			"access_token" => $access_token
		];
	}

	public static function verify_token(
		string $token,
	): object|bool {
		try {
			return JWT::decode($token, new Key($_ENV["SECRET_TOKEN_KEY"], "HS256"));
		} catch (\Throwable $th) {
			return false;
		}
	}
}
