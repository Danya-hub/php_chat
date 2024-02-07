<?php

namespace App\Services;

use App\Api\Logs\ApiErrorList;
use App\Api\Logs\FormValidMessage;
use App\Utils\Auth;

class Signin
{
	public $email;
	public $password;

	public function __construct()
	{
		global $connection;

		$this->email = mysqli_real_escape_string($connection, $_POST["email"] ?? '');
		$this->password = mysqli_real_escape_string($connection, $_POST["password"] ?? '');
	}

	public function login(): array
	{
		global $connection;

		if (
			empty($this->email) ||
			empty($this->password)
		) {
			FormValidMessage::fields_require();
		}

		$select_users_by_email_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$this->email}'");

		if (mysqli_num_rows($select_users_by_email_query) === 0) {
			FormValidMessage::wrong_password_or_email();
		}

		$founded_user = mysqli_fetch_assoc($select_users_by_email_query);

		$is_valid_password = password_verify($this->password, $founded_user["password"]);

		if (!$is_valid_password) {
			FormValidMessage::wrong_password_or_email();
		}

		$payload = [
			"user_id"	=> $founded_user["id"],
		];

		Auth::save_tokens($payload);

		$body = [
			"location" => APP_URL . "/chats",
		];

		return $body;
	}
}
