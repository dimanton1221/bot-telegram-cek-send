<?php
require "config.php";
require "class.php";
$data = file_get_contents($argv[1]);
unlink($argv[1]);
file_put_contents("php://stderr", "Hapus file " . $argv[1] . "\n");
$json = json_decode($data, 1);
$pesans = $json['message'];
$client = $chat_id = $pesans['from']['id'];
$pesan = $pesans['text'];
$message_id = $pesans['message_id'];
$tanggal = date("Y-m-d");
$name = $pesans['chat']['first_name'];