<?php

namespace App\Controllers;

use App\Api\Interaction;
use App\Router\ViewLoader;
use App\Services;

class User extends ViewLoader
{
	public static function get_users_by_name(): void
	{
		$response = Interaction::get_response(function () {
			$founded_users = Services\User::get_users_by_name($_GET["name"]);

			return $founded_users;
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}

	public static function get_user_by_id(): void
	{
		$response = Interaction::get_response(function () {
			$founded_users = Services\User::get_user_by_id(
				$_GET["user_id"],
			);

			return $founded_users;
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
