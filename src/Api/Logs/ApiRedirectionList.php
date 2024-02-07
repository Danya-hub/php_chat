<?php

namespace App\Api\Logs;

class ApiRedirectionList extends Log {
	public static function not_modified(
		array $data = [],
		string $message = "not_modified",
	) {
		parent::Redirection([
			...$data,
			"message" => $message,
		], 304);
	}
}