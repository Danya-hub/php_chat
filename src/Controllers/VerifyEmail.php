<?php

namespace App\Controllers;

use App\Api\Interaction;
use App\Utils\Auth;
use App\Router\Router;
use App\Router\ViewLoader;
use App\Utils\TempToken;
use App\Services;

class VerifyEmail extends ViewLoader
{
	public static function get_verify_email_page(array $options): void
	{
		$is_expired = TempToken::expire("account_verification/{$_SESSION["message_to_address"]}");

		if ($is_expired) {
			Router::redirect("signup/page");
		}

		self::load_view(
			"verify_email.php",
			HMF_TEMPLATE,
			$options
		);
	}

	public static function check_code()
	{
		$response = Interaction::get_response(function () {
			$service = new Services\VerifyEmail();

			return $service->check_code();
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
