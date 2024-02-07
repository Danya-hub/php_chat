<?php

namespace App\Api\Logs;

class Log
{
	private static function set_up(
		array $body,
		int $status_code,
	): string {
		http_response_code($status_code);

		$response = [
			"body" => $body,
			"success" => $status_code < 300,
		];

		return json_encode($response);
	}

	public static function Success(
		array $body,
		int $status_code = 200,
	): string {
		return self::set_up($body, $status_code);
	}

	public static function Redirection(
		array $body,
		int $status_code = 308,
	): void {
		$response = self::set_up($body, $status_code);

		throw new \Exception($response);
	}

	public static function Error(
		array $body,
		int $status_code = 400,
	): void {
		$response = self::set_up($body, $status_code);

		throw new \Exception($response);
	}
}
