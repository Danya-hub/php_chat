<?php

namespace App\Services;

use App\Api\Logs\ApiErrorList;
use App\Api\Logs\FormValidMessage;
use App\Router\Router;
use App\Utils\Auth;
use App\Utils\TempToken;

class Signup extends Auth
{
	public array $user = [];
	public string $confirm_password;
	public bool $is_confirmed;

	public function __construct()
	{
		global $connection;

		$this->user["first_name"] = mysqli_real_escape_string($connection, $_POST["first_name"] ?? '');
		$this->user["last_name"] = mysqli_real_escape_string($connection, $_POST["last_name"] ?? '');
		$this->user["email"] = mysqli_real_escape_string($connection, $_POST["email"] ?? '');
		$this->user["password"] = mysqli_real_escape_string($connection, $_POST["password"] ?? '');
		$this->confirm_password = $_POST["confirm_password"] ?? '';
		$this->is_confirmed = empty($_POST["sign"] ?? '');
	}

	public function create_account(): array
	{
		global $connection;

		if (
			empty($this->user["first_name"]) ||
			empty($this->user["last_name"]) ||
			empty($this->user["email"]) ||
			empty($this->user["password"]) ||
			empty($this->confirm_password) ||
			$this->is_confirmed
		) {
			FormValidMessage::fields_require();
		}

		if ($this->user["password"] !== $this->confirm_password) {
			FormValidMessage::value_not_same();
		}

		$is_email = filter_var($this->user["email"], FILTER_VALIDATE_EMAIL);

		if (!$is_email) {
			FormValidMessage::wrong_format_email();
		}

		$select_users_by_emails_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$this->user["email"]}'");

		if (mysqli_num_rows($select_users_by_emails_query) > 0) {
			FormValidMessage::user_already_exists();
		}

		$unique_avatar_name = null;

		if ($_FILES["avatar"]["name"] !== "") {
			$image_name = $_FILES["avatar"]["name"];
			$tmp_name = $_FILES["avatar"]["tmp_name"];
			$split_image_name = explode(".", $image_name);
			$image_ext = end($split_image_name);

			$exts = ["jpg", "png"];

			if (!in_array($image_ext, $exts)) {
				FormValidMessage::wrong_format_image();
			}

			$time = time();
			$unique_avatar_name = "{$time}.{$image_ext}";
			$success_move_file = move_uploaded_file($tmp_name, ROOT_DIR . "/dist/" . $unique_avatar_name);

			if (!$success_move_file) {
				FormValidMessage::image_cannot_be_load();
			}
		}

		$user_id = uniqid("", true);
		$hashed_password = password_hash($this->user["password"], PASSWORD_BCRYPT);

		$_SESSION["mysqli_query"] = [
			"user_id" => $user_id,
			"query" => "INSERT INTO users (id, first_name, last_name, email, password, avatar) VALUES ('{$user_id}', '{$this->user["first_name"]}', '{$this->user["last_name"]}', '{$this->user["email"]}', '{$hashed_password}', '{$unique_avatar_name}')"
		];

		$_SESSION["new_temp_user"] = $this->user;
		parent::confirm_user_email(
			[
				"has_exp" => true,
				"expire" => 5,
				"error_message" => "Код подтверждения уже был отправлен",
			]
		);

		$body = [
			"location" => "verify_email/{$this->user["email"]}",
		];

		return $body;
	}
}
