<?php

namespace App\Controllers;

use App\Api\Interaction;
use App\Api\Logs\ApiErrorList;
use App\Router\ViewLoader;
use App\Utils\Auth;
use App\Services;

class Message extends ViewLoader
{
	public static function write_message()
	{
		$response = Interaction::get_response(function () {
			return Services\Message::write_message();
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}

	public static function get_messages_by_chat_id()
	{
		$response = Interaction::get_response(function () {
			return Services\Message::get_messages_by_chat_id(
				$_GET["chat_id"]
			);
		});

		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
