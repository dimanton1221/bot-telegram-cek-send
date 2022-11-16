<?php
ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");
error_log( "Hello, errors!" );

$data = file_get_contents("php://input");
$random = "./logs/" . rand(1, 1000000);
file_put_contents($random, $data);
$file = "ws.php";
$file = realpath($file);
$real = realpath($random);
exec('php -f "' . $file . '" "' . $real . '" > /dev/null &');
