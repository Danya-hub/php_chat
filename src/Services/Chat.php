<?php

namespace App\Services;

use App\Api\Logs\ApiErrorList;
use App\Controllers\ApiError;
use App\Utils\Auth;
use App\Utils\JWTToken;
use Firebase\JWT\JWT;

class Chat
{
	public static function get_chats_by_user(
		string $user_id
	): array {
		global $connection;

		if (empty($user_id)) {
			ApiErrorList::user_not_found();
		}

		$formatted_id = mysqli_real_escape_string($connection, $user_id);

		$select_chats_by_user_query = mysqli_query(
			$connection,
			"SELECT c.id, c.chat_status, c.created_at, c.last_message, c.updated_at, u.id AS companion_id, u.first_name, u.last_name, u.avatar FROM `chats` c
			JOIN `users` u ON u.id = (
    	  SELECT CASE 
					WHEN c.user1_id = '{$formatted_id}' THEN c.user2_id 
					ELSE c.user1_id
    	  END
    	) WHERE c.user1_id = '{$formatted_id}' OR c.user2_id = '{$formatted_id}'
			ORDER BY c.updated_at ASC"
		);

		$founded_chats = mysqli_fetch_all($select_chats_by_user_query, MYSQLI_ASSOC);

		return $founded_chats;
	}

	public static function get_chat_by_id(
		string $chat_id,
	): array|null {
		global $connection;

		$query_select_chat_by_id = mysqli_query($connection, "SELECT * FROM chats WHERE id = '{$chat_id}'");

		$found_chat = mysqli_fetch_assoc($query_select_chat_by_id);

		return $found_chat;
	}

	public static function get_companion_by_chat(
		string $chat_id,
		string $sender_id,
	): array {
		global $connection;

		if (empty($chat_id)) {
			ApiErrorList::user_not_found();
		}

		$formatted_chat_id = mysqli_real_escape_string($connection, $chat_id);

		$select_user_by_chat_query = mysqli_query(
			$connection,
			"SELECT c.id, c.chat_status, c.created_at, c.last_message, c.updated_at, u.id AS companion_id, u.first_name, u.last_name, u.avatar FROM `chats` c
			JOIN `users` u ON u.id = (
    	  SELECT CASE 
					WHEN c.user1_id = '{$sender_id}' THEN c.user2_id 
					ELSE c.user1_id
    	  END
    	) WHERE c.id = '{$formatted_chat_id}'"
		);

		if (mysqli_num_rows($select_user_by_chat_query) === 0) {
			ApiErrorList::user_not_found();
		}

		$founded_companion = mysqli_fetch_assoc($select_user_by_chat_query);

		return $founded_companion;
	}

	public static function add_to_recomended(string $user_id): array
	{
		global $connection;

		if (!isset($_SESSION["all_users_for_messaging"])) {
			$_SESSION["all_users_for_messaging"] = [];
		}

		$formatted_user_id = mysqli_real_escape_string($connection, $user_id);
		$existed_users = array_filter($_SESSION["all_users_for_messaging"], function (array $user) use ($formatted_user_id) {
			return $user["id"] == $formatted_user_id;
		});
		$has_user = count($existed_users) > 0;

		if (!$has_user) {
			$select_user_by_id_query = mysqli_query($connection, "SELECT * FROM users WHERE id = '{$formatted_user_id}'");

			if (mysqli_num_rows($select_user_by_id_query) == 0) {
				ApiErrorList::smth_wrong();
			}

			$chat_id = uniqid("", true);
			$founded_user = mysqli_fetch_assoc($select_user_by_id_query);

			$_SESSION["all_users_for_messaging"][] = [
				"chat_id" => $chat_id,
				"id" => $founded_user["id"],
				"avatar" => $founded_user["avatar"],
				"first_name" => $founded_user["first_name"],
				"last_name" => $founded_user["last_name"],
			];
		}

		return $_SESSION["all_users_for_messaging"];
	}

	public static function add_to_regular(
		string $companion,
		string $chat_id,
	): string {
		global $connection;

		$verified_access_token = JWTToken::verify_token($_COOKIE["access_token"]);

		$query_write_message = mysqli_query($connection, "INSERT INTO chats (id, user1_id, user2_id, chat_status) VALUES ('{$chat_id}', '{$verified_access_token->user_id}', '{$companion}', 'active')");

		if (!$query_write_message) {
			ApiErrorList::smth_wrong();
		}

		$_SESSION["all_users_for_messaging"] = array_filter(
			$_SESSION["all_users_for_messaging"],
			function (array $user) use ($companion) {
				return $user["id"] != $companion;
			}
		);

		return $chat_id;
	}
}
