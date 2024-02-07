<?php

namespace App\Api;

use Closure;

class Middleware
{

	public function __construct(
		public ?Closure $before,
	) {
	}

	public function __call(string $name, array $arguments): mixed
	{
		$this->before();

		echo "325";

		return call_user_func_array([$this, $name], $arguments);
	}

	public function set_next(callable $handler): self
	{
		try {
			$handler();
		} catch (\Exception $e) {
			throw $e->getMessage();
			exit();
		}

		return $this;
	}
}
