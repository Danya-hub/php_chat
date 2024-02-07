<?php

namespace App\Router;

require ROOT_DIR . "/src/Router/routes.php";

class Router
{
	static public string $output;

	static public function set_params(
		array $url_values,
		string $request_name,
		string $request_role,
	): void {
		$method = $_SERVER["REQUEST_METHOD"];

		for ($i = 0; $i < count(ROUTES[$method][$request_role][$request_name]["params"]); $i++) {
			$key = ROUTES[$method][$request_role][$request_name]["params"][$i];
			$value = $url_values[$i + 2] ?? '';

			if ($method === "GET") {
				$_GET[$key] = $value;
			} else {
				$_POST[$key] = $value;
			}
		}
	}

	static public function render(string $default_route = ""): void
	{
		$method = $_SERVER["REQUEST_METHOD"];

		if (!isset($_GET["route"])) {
			self::redirect($default_route, $method);
			return;
		}

		$url_values = explode("/", $_GET["route"]);
		$request_name = $url_values[0];
		$request_role = isset($url_values[1]) ? $url_values[1] : "page";

		$is_existed_page = isset(ROUTES[$method][$request_role][$request_name]);

		if (!$is_existed_page) {
			ROUTES[$method][$request_role]["not_found"]["action"]();
			exit;
		}

		self::set_params(
			$url_values,
			$request_name,
			$request_role
		);

		ROUTES[$method][$request_role][$request_name]["action"]();
	}

	static public function redirect(
		string $request_name,
		string $method = "GET",
	): void {
		$_SERVER["REQUEST_METHOD"] = $method;

		header("Location: " . APP_URL . "/" . $request_name);
	}
}
