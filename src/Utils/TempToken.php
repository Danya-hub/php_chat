<?php

namespace App\Utils;

// if (!isset($_SESSION["TEMP_TOKEN"])) {
// 	$_SESSION["TEMP_TOKEN"] = [];
// }

class TempToken
{
	public string $token;

	public function __construct(
		public string $topic,
		public int $expire = 5,
	) {
	}

	public function generate(): void
	{
		$_SESSION["TEMP_TOKEN"][$this->topic] = time() + $this->expire * 60;
	}

	static public function expire(string $topic): bool
	{
		$now = time();

		if (!isset($_SESSION["TEMP_TOKEN"][$topic])) {
			return true;
		}

		$is_expired = $_SESSION["TEMP_TOKEN"][$topic] < $now;

		if ($is_expired) {
			unset($_SESSION["TEMP_TOKEN"][$topic]);
		}

		return $is_expired;
	}
}
