<?php
require "config.php";
require "class.php";


// how current dir
$dir = __DIR__;
echo $dir;
$url = "https://api.telegram.org/bot$token/setWebhook?url=" . current_url() . "webhook.php";
// make a file
$myfile = fopen("webhook.txt", "w") or die("Unable to open file!");
file_put_contents("./logs/index.php.txt", file_get_contents($url));
echo $token . "<br>";

echo "Server Sudah Berjalan :)";
