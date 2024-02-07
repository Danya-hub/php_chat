<?php

namespace App\Controllers;

use App\Api\Interaction;
use App\Api\Logs\ApiErrorList;
use App\Router\Router;
use App\Router\ViewLoader;
use App\Utils\Auth;
use App\Services;

class Chat extends ViewLoader
{
	public static function get_chats_page(array $options): void
	{
		self::load_view(
			"mychats.php",
			HMF_TEMPLATE,
			$options
		);
	}

	public static function get_companion_by_chat()
	{
		$response = Interaction::get_response(function () {
			return Services\Chat::get_companion_by_chat(
				$_GET["chat_id"],
				$payload["user_id"],
			);
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}

	public static function get_chats_by_user(): void
	{
		$response = Interaction::get_response(function () {
			return Services\Chat::get_chats_by_user(
				$payload["user_id"],
			);
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}

	public static function add_to_recomended(): void
	{
		$response = Interaction::get_response(function () {
			return Services\Chat::add_to_recomended($_POST["user_id"]);
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
