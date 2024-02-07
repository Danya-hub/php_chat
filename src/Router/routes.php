<?php

use App\Api\Logs\ApiErrorList;
use App\Api\Middleware;
use App\Controllers\Chat;
use App\Controllers\Signin;
use App\Controllers\Signup;
use App\Controllers\VerifyEmail;
use App\Controllers\User;
use App\Controllers\ApiError;
use App\Controllers\Message;
use App\Router\Router;
use App\Utils\Auth;

$middleware = new Middleware(
	function () {
		$refresh = Auth::is_auth();

		if ($refresh) {
			$_SESSION["auth_user"] = $refresh;
		}
	}
);

define("ROUTES", [
	"GET" => [
		"page" => [
			"signin" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (isset($_SESSION["auth_user"])) {
							Router::redirect("chats/page");
						}
					})->set_next(function () {
						Signin::get_signin_page([
							"title" => "Войти в учетную запись",
						]);
					});
				}
			],
			"signup" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (isset($_SESSION["auth_user"])) {
							Router::redirect("chats/page");
						}
					})->set_next(function () {
						Signup::get_signup_page([
							"title" => "Регистрация",
						]);
					});
				}
			],
			"chats" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							Router::redirect("signin/page");
						}
					})->set_next(function () {
						Chat::get_chats_page([
							"title" => "Чаты",
						]);
					});
				}
			],
			"verify_email" => [
				"params" => ["email"],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (isset($_SESSION["auth_user"])) {
							Router::redirect("chats/page");
						}
					})->set_next(function () {
						VerifyEmail::get_verify_email_page([
							"title" => "Подтверждение своей почты",
						]);
					});
				}
			],
			"not_found" => [
				"params" => [],
				"action" => function (): void {
					ApiError::notFound_page([
						"title" => "Страница не найдена",
					]);
				}
			],
		],
		"data" => [
			"find_users_by_name" => [

				"params" => ["name"],
				"action" => function (): void {
					User::get_users_by_name();
				}
			],
			"get_chats_by_user" => [

				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::not_auth();
						}
					})->set_next(function () {
						Chat::get_chats_by_user();
					});
				}
			],
			"get_companion_by_chat" => [
				"params" => ["chat_id"],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::not_auth();
						}
					})->set_next(function () {
						Chat::get_companion_by_chat();
					});
				}
			],
			"get_user_by_id" => [
				"params" => ["user_id"],
				"action" => function (): void {
					User::get_user_by_id();
				}
			],
			"get_messages_by_chat_id" => [
				"params" => ["chat_id"],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::not_auth();
						}
					})->set_next(function () {
						Message::get_messages_by_chat_id();
					});
				}
			],
			"not_found" => [
				"params" => [],
				"action" => function (): void {
					ApiError::not_found();
				}
			],
		],
	],
	"POST" => [
		"data" => [
			"create_account" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::smth_wrong();
						}
					})->set_next(function () {
						Signup::create_account();
					});
				}
			],
			"check_code" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::smth_wrong();
						}
					})->set_next(function () {
						VerifyEmail::check_code();
					});
				}
			],
			"login" => [

				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::smth_wrong();
						}
					})->set_next(function () {
						Signin::login();
					});
				}
			],
			"add_to_recomended" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::not_auth();
						}
					})->set_next(function () {
						Chat::add_to_recomended();
					});
				}
			],
			"write_message" => [
				"params" => [],
				"action" => function () use ($middleware): void {
					$middleware->set_next(function () {
						if (!isset($_SESSION["auth_user"])) {
							ApiErrorList::not_auth();
						}
					})->set_next(function () {
						Message::write_message();
					});
				}
			],
			"not_found" => [
				"params" => [],
				"action" => function (): void {
					ApiError::not_found();
				}
			],
			"send_code" => [
				"params" => [],
				"action" => function (): void {
					Signup::send_code();
				}
			],
		],
	],
]);
