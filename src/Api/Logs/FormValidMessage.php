<?php

namespace App\Api\Logs;

class FormValidMessage extends Log
{
	public static function fields_require(
		array $data = [],
		string $message = "fields_require",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function user_already_exists(
		array $data = [],
		string $message = "user_already_exists",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function wrong_format_image(
		array $data = [],
		string $message = "wrong_format_image",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function image_cannot_be_load(
		array $data = [],
		string $message = "image_cannot_be_load",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function value_not_same(
		array $data = [],
		string $message = "value_not_same",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function wrong_password_or_email(
		array $data = [],
		string $message = "wrong_password_or_email",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}

	public static function wrong_format_email(
		array $data = [],
		string $message = "wrong_format_email",
	): void {
		parent::Error([
			...$data,
			"message" => $message,
		]);
	}
}
