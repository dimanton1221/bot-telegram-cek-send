<?php
require "config.php";
require "class.php";
$data = file_get_contents("php://input");
$json = json_decode($data, 1);
$pesans = $json['message'];
$client = $chat_id = $pesans['from']['id'];
$name = $pesans['from']['first_name'];
$pesan = $pesans['text'];
$message_id = $pesans['message_id'];
$tanggal = date("Y-m-d");
$name = $pesans['chat']['first_name'];




pesan($pesan);