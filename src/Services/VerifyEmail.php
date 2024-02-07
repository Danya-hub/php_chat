<?php

namespace App\Services;

use App\Api\Logs\ApiErrorList;
use App\Api\Logs\FormValidMessage;
use App\Utils\Auth;

class VerifyEmail extends Auth
{
	public string $user_code;
	public string $generated_code;

	public function __construct()
	{
		$this->user_code = $_POST["confirm_code"];
		$this->generated_code = $_SESSION["generated_code"];
	}

	public static function generate_code(): string
	{
		$code = (string) random_int(100000, 999999);
		$_SESSION["generated_code"] = $code;

		return $code;
	}

	public function check_code(): array
	{
		global $connection;

		if ($this->user_code !== $this->generated_code) {
			FormValidMessage::value_not_same();
		}

		$user_id = $_SESSION["mysqli_query"]["user_id"];

		$create_new_account_query = mysqli_query($connection, $_SESSION["mysqli_query"]["query"]);

		if (!$create_new_account_query) {
			ApiErrorList::smth_wrong();
		}

		$payload = [
			"user_id" => $user_id,
		];
		parent::save_tokens($payload);

		unset($_SESSION["mysqli_query"]);
		unset($_SESSION["TEMP_TOKEN"]["account_verification/{$_SESSION["message_to_address"]}"]);

		return [
			"location" => "chats",
		];
	}
}
