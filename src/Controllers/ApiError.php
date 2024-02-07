<?php

namespace App\Controllers;

use App\Router\ViewLoader;

class ApiError extends ViewLoader
{
	public static function notFound_page(array $options): void
	{
		http_response_code(404);
		self::load_view(
			"not_found.php",
			HMF_TEMPLATE,
			$options
		);
	}
	
	public static function not_found() {
		$response = json_encode([
			"message" => "The request is not found",
		]);

		http_response_code(404);
		self::load_json(
			$response,
			M_TEMPLATE,
		);
	}
}
