<?php

namespace App\Controllers;

use App\Api\Interaction;
use App\Router\Router;
use App\Router\ViewLoader;
use App\Utils\Auth;
use App\Services;
use App\Utils\TempToken;

class Signup extends ViewLoader
{
	public static function get_signup_page(array $options): void
	{
		self::load_view(
			"signup.php",
			HMF_TEMPLATE,
			$options
		);
	}

	public static function create_account(): void
	{
		$response = Interaction::get_response(function () {
			if (isset($_SESSION["message_to_address"])) {
				$is_expired = TempToken::expire("account_verification/{$_SESSION["message_to_address"]}");

				if (!$is_expired) {
					Router::redirect("verify_email/page/{$_SESSION["message_to_address"]}");
				}
			}

			$service = new Services\Signup();

			return $service->create_account();
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}

	public static function send_code()
	{
		$response = Interaction::get_response(function () {
			$service = new Services\Signup();

			return $service::confirm_user_email([
				"has_exp" => true,
				"expire" => 5,
				"error_message" => "Код подтверждения уже был отправлен",
			]);
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
