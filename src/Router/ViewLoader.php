<?php

namespace App\Router;

class ViewLoader
{
	public static string $views_dir = ROOT_DIR . "/src/views/";

	public static function load_view(
		string $view_path,
		string $template_path,
		array $options = [],
	): void {
		$response = self::$views_dir . $view_path;
		require $template_path;
	}

	public static function load_json(
		string $response,
		string $template_path,
	): void {
		header("Content-Type: application/json");
		require $template_path;
	}
}
