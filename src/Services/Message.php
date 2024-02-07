<?php

namespace App\Services;

use App\Api\Logs\ApiErrorList;
use App\Services\Chat;
use App\Utils\JWTToken;

class Message extends Chat
{
	public static function write_message(): array
	{
		global $connection;

		$to_user = mysqli_real_escape_string($connection, $_POST["to_user"]);
		$message = mysqli_real_escape_string($connection, $_POST["message"]);
		$chat_id = mysqli_real_escape_string($connection, $_POST["chat_id"]);

		$found_chat = parent::get_chat_by_id($chat_id);

		if (!isset($found_chat)) {
			parent::add_to_regular($to_user, $chat_id);
		}

		$verified_access_token = JWTToken::verify_token($_COOKIE["access_token"]);

		$query_write_message = mysqli_query($connection, "INSERT INTO messages (`chat_id`, `sender_id`, `reciever_id`, `message`) VALUES ('{$chat_id}', '{$verified_access_token->user_id}', '{$to_user}', '{$message}')");

		if (!$query_write_message) {
			ApiErrorList::smth_wrong();
		}

		$updated_at = date('Y-m-d H:i:s', time());
		$query_update_chat = mysqli_query($connection, "UPDATE chats SET `last_message` = '{$message}', updated_at = '{$updated_at}' WHERE id = '{$_POST["chat_id"]}'");

		if (!$query_update_chat) {
			ApiErrorList::smth_wrong();
		}

		$body = self::get_last_message($chat_id);

		return $body;
	}

	public static function get_messages_by_chat_id(
		string $chat_id,
	): array {
		global $connection;

		$formatted_chat_id = mysqli_real_escape_string($connection, $chat_id);

		$verified_access_token = JWTToken::verify_token($_COOKIE["access_token"]);

		$query_select_all_messages = mysqli_query(
			$connection,
			"SELECT * FROM (
				SELECT *, sender_id = '{$verified_access_token->user_id}' AS are_sender FROM messages WHERE chat_id = '{$formatted_chat_id}' ORDER BY created_at DESC LIMIT 10
				) AS last_messages ORDER BY created_at ASC
			"
		);

		if (!$query_select_all_messages) {
			ApiErrorList::smth_wrong();
		}

		$body = mysqli_fetch_all($query_select_all_messages, MYSQLI_ASSOC);

		return $body;
	}

	public static function get_last_message(
		string $chat_id,
	): array {
		global $connection;

		$query_select_last_message = mysqli_query(
			$connection,
			"SELECT * FROM messages WHERE chat_id = '{$chat_id}' ORDER BY created_at DESC LIMIT 1;"
		);

		if (!$query_select_last_message) {
			ApiErrorList::smth_wrong();
		}

		$body = mysqli_fetch_assoc($query_select_last_message);

		return $body;
	}
}
