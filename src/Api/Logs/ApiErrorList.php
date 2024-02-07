<?php

namespace App\Api\Logs;

class ApiErrorList extends Log {
	public static function not_auth(
		array $data = [],
		string $message = "not_authorized",
	): void
	{
		parent::Error([
			...$data,
			"message" => $message,
		], 401);
	}

	public static function not_found(
		array $data = [],
		string $message = "not_found",
	): void
	{
		parent::Error([
			...$data,
			"message" => $message,
		], 404);
	}

	public static function smth_wrong(
		array $data = [],
		string $message = "smth_wrong",
	): void
	{
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function user_not_found(
		array $data = [],
		string $message = "user_not_found",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}
}