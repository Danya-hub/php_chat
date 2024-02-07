<?php

namespace App\Controllers;

use App\Api\Interaction;
use App\Api\Logs\ApiErrorList;
use App\Router\Router;
use App\Router\ViewLoader;
use App\Utils\Auth;
use App\Services;

class Signin extends ViewLoader
{
	public static function get_signin_page(array $options): void
	{
		self::load_view(
			"signin.php",
			HMF_TEMPLATE,
			$options,
		);
	}

	public static function login(): void
	{
		$response = Interaction::get_response(function () {
			$service = new Services\Signin();

			return $service->login();
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
