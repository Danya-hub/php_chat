<?php

namespace App\Api;

use App\Api\Logs\Log;

class Interaction
{
	public static function get_response(
		callable $callback,
	): string {
		try {
			$body = $callback();

			$response = Log::Success($body);
		} catch (\Exception $e) {
			$response = $e->getMessage();
		}

		return $response;
	}
}
