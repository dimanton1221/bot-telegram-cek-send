<?php
require 'class.php';

$user = "hasilbobol23@gmail.com";
$pass = "ibuku354A@";

$data = loginkok($user, $pass);
$token = $data['token'];
print_r($data);
$post = array(
    'language' => 'id',
    'token' => $token
);
$send = req_post('coin/get-balances', $post);
$getBalance = json_decode($send, true);

foreach ($getBalance['coins'] as $key => $value) {
    echo $value['coin'] . " : " . $value['balance'] . "\n";
}
$send = req_post('account/get-user-info', $post);
$json = json_decode($send, true);
// echo user_name, user_email, user_id
echo $json['user_name'] . "\n";
echo $json['user_email'] . "\n";
echo $json['user_id'] . "\n";