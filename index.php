<?php
declare(strict_types=1);
session_start();

use App\Router\Router;

require __DIR__ . "/vendor/autoload.php";

require __DIR__ . "/src/config/paths.php";
require __DIR__ . "/src/config/env.php";
require __DIR__ . "/src/config/server.php";

require __DIR__ . "/src/views/Templates/index.php";

Router::render("signin");