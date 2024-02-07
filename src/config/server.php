<?php
try {
	$connection = mysqli_connect(
		$_ENV["DB_HOSTNAME"],
		$_ENV["DB_USERNAME"],
		$_ENV["DB_PASSWORD"],
		$_ENV["DB_NAME"],
	);
} catch (Exception $error) {
	echo $error->getMessage();
	exit;
}
