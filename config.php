<?php 


define("ROOT", "/var/www/html/projetboutik");

require ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();


define('DB_TYPE', $_ENV['DB_TYPE']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define("WEBROOT", $_ENV["WEBROOT"]);
define("VIEW", ROOT."/views/");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// On inclut le fichier web.php qui a les différentes routes
require_once ROOT."/src/core/web.php";

// config/database.php
