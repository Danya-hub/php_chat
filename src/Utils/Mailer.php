<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
	public $mail;

	public function __construct()
	{
		$this->mail = new PHPMailer(true);

		$this->mail->isSMTP();
		$this->mail->Host = $_ENV["MAIL_HOST"];
		$this->mail->SMTPAuth = true;
		$this->mail->Username = $_ENV["MAIL_FROM_ADDRESS"];
		$this->mail->Password = $_ENV["MAIL_PASSWORD"];
		$this->mail->SMTPSecure = "tls";
		$this->mail->Port = 587;
		$this->mail->CharSet = $_ENV["MAIL_CHARSET"];
	}

	public function send_plain_message(
		string $to_address,
		string $to_name,
		string $subject,
		string $body,
		array $options = [
			"has_exp" => false,
			"expire" => 0,
			"message" => "",
		],
	): bool {
		$is_expired = TempToken::expire("account_verification/{$to_address}");

		if (!$is_expired) {
			return false;
		}

		$token = new TempToken(
			"account_verification/{$to_address}",
			$options["expire"],
		);
		$token->generate();

		$this->mail->setFrom($_ENV["MAIL_FROM_ADDRESS"], $_ENV["MAIL_FROM_NAME"]);
		$this->mail->addAddress($to_address);
		$this->mail->addReplyTo($to_address, $to_name);

		$this->mail->Subject = $subject;
		$this->mail->Body = $body;
		$this->mail->AltBody = $body;

		$this->mail->send();

		if ($options["has_exp"]) {
			$_SESSION["message_to_address"] = $to_address;
		}

		return true;
	}
}
