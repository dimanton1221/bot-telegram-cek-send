<?php
require "config.php";
require "class.php";

$url = "https://api.telegram.org/bot$token/setWebhook?url=" . current_url() . "webhook.php";
// make a file
mkdir("./logs/", 0777);
chmod("./logs/", 0777);
chmod("./logs", 0777);
chmod("./asa/a.php", 0777);
// make a file
$myfile = fopen("./logs/webhook.txt", "w") or die("Unable to open file!");  
$myfile = fopen("webhook.txt", "w") or die("Unable to open file!");
file_put_contents("./logs/index.php.txt", file_get_contents($url));
echo $token . "<br>";

echo "Server Sudah Berjalan :)";
