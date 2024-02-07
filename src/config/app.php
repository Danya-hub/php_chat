<?php

$protocol = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https://" : "http://";
$host = filter_var($_SERVER["HTTP_HOST"], FILTER_SANITIZE_URL);
$app_name = "php_chat";
$formatted_root_dir = str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]) . "/{$app_name}";
$root_url = $protocol . $host;
$app_url = $protocol . $host . "/{$app_name}";

define("APP", [
	"HOST" => $host,
	"PROTOCOL" => $protocol,
	"APP_NAME" => $app_name,
]);
