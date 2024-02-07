<?php

namespace App\Utils;

use App\Api\Logs\ApiErrorList;
use App\Api\Logs\ApiRedirectionList;
use App\Router\Router;
use App\Services\VerifyEmail;
use App\Utils\JWTToken;
use App\Utils\Mailer;
use mysqli;

class Auth
{
	static public function is_auth(): object|bool
	{
		if (!isset($_COOKIE["access_token"])) {
			return false;
		}

		$verified_access_token = JWTToken::verify_token($_COOKIE["access_token"]);

		if (!$verified_access_token) {
			return false;
		}

		return $verified_access_token;
	}

	static public function save_tokens(array $payload): void
	{
		global $connection;

		$tokens = JWTToken::generate_tokens($payload);

		$query_select_refresh_token = mysqli_query($connection, "SELECT * FROM refresh_token WHERE user_id = '{$payload["user_id"]}'");

		if (mysqli_num_rows($query_select_refresh_token) == 0) {
			$query_update_refresh_token = mysqli_query($connection, "INSERT INTO refresh_token (user_id, refresh_token) VALUES ('{$payload["user_id"]}', '{$tokens["refresh_token"]}')");
		} else {
			$updated_at = date('Y-m-d H:i:s', time());

			$query_update_refresh_token = mysqli_query($connection, "UPDATE refresh_token SET `refresh_token` = '{$tokens["refresh_token"]}', `updated_at` = '{$updated_at}' WHERE `user_id` = '{$payload["user_id"]}'");
		}

		if (!$query_update_refresh_token) {
			ApiErrorList::smth_wrong();
		}

		setcookie(
			"access_token",
			$tokens["access_token"],
			time() + 3600,
			"/",
		);
		setcookie(
			"refresh_token",
			$tokens["refresh_token"],
			time() + 604800,
			"/",
			false,
			true,
		);
	}

	static public function refresh(): bool|array
	{
		global $connection;

		if (!isset($_COOKIE["refresh_token"])) {
			return false;
		}

		$verified_refresh_token = JWTToken::verify_token($_COOKIE["refresh_token"]);

		if (!$verified_refresh_token) {
			return false;
		}

		$query_select_refresh_token = mysqli_query($connection, "SELECT * FROM refresh_token WHERE refresh_token = '{$_COOKIE["refresh_token"]}'");

		if (!$query_select_refresh_token) {
			return false;
		}

		$founded_token = mysqli_fetch_assoc($query_select_refresh_token);

		$payload = [
			"user_id" => $founded_token["user_id"],
		];

		self::save_tokens($payload);

		return $payload;
	}

	static public function confirm_user_email(array $options = [
		"has_exp" => false,
		"expire" => 0,
		"error_message" => "",
	])
	{
		if (!isset($_SESSION["new_temp_user"])) {
			ApiErrorList::smth_wrong(
				[],
				$options["error_message"],
			);
		}

		$generated_code = VerifyEmail::generate_code();

		$mailer = new Mailer();

		$is_sended = $mailer->send_plain_message(
			$_SESSION["new_temp_user"]["email"],
			"{$_SESSION["new_temp_user"]["last_name"]} {$_SESSION["new_temp_user"]["first_name"]}",
			"PHP CHAT. Код подтверждения",
			$generated_code,
			$options,
		);

		if (!$is_sended) {
			ApiRedirectionList::not_modified();
		}

		$body = [
			"message" => "Код отправлен"
		];

		return $body;
	}
}
