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


if (preg_match("/\/login/", $pesan)) {
    // remove /login
    $pesan = str_replace("/login", "", $pesan);
    // remove space
    $pesan = trim($pesan);
    // explode
    $pesan = explode(" ", $pesan);
    // get user
    $user = $pesan[0];
    // get pass
    $pass = $pesan[1];

    $data = loginkok($user, $pass);
    if (!isset($data['token'])) {
        pesan("Login gagal");
    }
    $token = $data['token'];
    $post = array(
        'language' => 'id',
        'token' => $token
    );
    $send = req_post('coin/get-balances', $post);
    $getBalance = json_decode($send, true);
    $isi = "";
    foreach ($getBalance['coins'] as $key => $value) {
        $isi .= $value['coin'] . " : " . $value['balance'] . "\n";
    }

    $send = req_post('account/get-user-info', $post);
    $json = json_decode($send, true);
    // echo user_name, user_email, user_id
    // add user_ to $isi
    $isi .= $json['user_name'] . "\n";
    $isi .= $json['user_email'] . "\n";
    $isi .= $json['user_id'] . "\n";
    pesan($isi);
}
