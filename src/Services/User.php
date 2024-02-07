<?php

namespace App\Services;

use App\Api\Logs\ApiErrorList;
use App\Utils\JWTToken;

class User
{
	public static function get_users_by_name(
		string $name
	): array {
		global $connection;

		if (empty($name)) {
			ApiErrorList::user_not_found();
		}

		$verified_access_token = JWTToken::verify_token($_COOKIE["access_token"]);

		if (!$verified_access_token) {
			ApiErrorList::smth_wrong();
		}

		$formatted_name = mysqli_real_escape_string($connection, $name);

		$select_users_by_name_query = mysqli_query($connection, "SELECT `id`, `avatar`, `first_name`, `last_name` FROM users WHERE (first_name REGEXP '^{$formatted_name}' OR last_name REGEXP '^{$formatted_name}') AND id != '{$verified_access_token->user_id}' LIMIT 5");

		if (mysqli_num_rows($select_users_by_name_query) === 0) {
			ApiErrorList::user_not_found();
		}

		$founded_users = mysqli_fetch_all($select_users_by_name_query, MYSQLI_ASSOC);

		return $founded_users;
	}

	public static function get_user_by_id(
		string $user_id,
	): array {
		global $connection;

		if (empty($user_id)) {
			ApiErrorList::user_not_found();
		}

		$formatted_id = mysqli_real_escape_string($connection, $user_id);

		$select_users_by_id_query = mysqli_query($connection, "SELECT `id`, `avatar`, `first_name`, `last_name` FROM users WHERE id='{$formatted_id}'");

		if (mysqli_num_rows($select_users_by_id_query) === 0) {
			ApiErrorList::user_not_found();
		}

		$founded_users = mysqli_fetch_assoc($select_users_by_id_query);

		return $founded_users;
	}
}
