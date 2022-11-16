<?php
function current_url()
{
    $url      = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $validURL = str_replace("&", "&amp", $url);
    $name_file = basename($_SERVER['PHP_SELF']);
    return str_replace(basename($_SERVER['PHP_SELF']), "", $validURL);
}

function pesan($pesan, $balas = null, $extend = null)
{
    $token = $GLOBALS['token'];
    $chat_id = $GLOBALS['chat_id'];
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&parse_mode=HTML&text=" . urlencode($pesan) . "&";
    if (isset($balas)) {
        $url .= 'reply_to_message_id=' . $balas . "&";
    }
    if (isset($extend)) {
        $url .= http_build_query($extend);
    }
    return file_get_contents($url);
}

function keyboard($pesan, $arrys = null)
{
    $token = $GLOBALS['token'];
    $chat_id = $GLOBALS['chat_id'];
    $url = "https://api.telegram.org/bot$token/";

    $kosongan = [];
    $no = 0;
    foreach ($arrys as $hasil) {
        $no2 = 0;
        foreach ($hasil as $x) {
            $template = ['text' => $x];
            $kosongan[$no][$no2] = $template;
            $no2++;
        }
        $no++;
    }
    $mentahan  = [
        'chat_id' => $chat_id,
        'text' => $pesan,
        'reply_markup' => [
            'keyboard' => $kosongan,
            "resize_keyboard" => true,
        ],
    ];

    $ch = curl_init($url . 'sendMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mentahan));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($ch, CURLOPT_ENCODING, '');

    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
}
function kirim_gambar($photo)
{
    $token = $GLOBALS['token'];
    $chat_id = $GLOBALS['chat_id'];
    $url = "https://api.telegram.org/bot$token/sendPhoto?chat_id=$chat_id&photo=" . urlencode($photo);
    file_get_contents($url);
}
function export_db($tables)
{
    $token = $GLOBALS['token'];
    $chat_id = $GLOBALS['chat_id'];
    /* vars for export */
    // database record to be exported
    $db_record = $tables;
    // optional where query
    $where = 'WHERE 1 ORDER BY 1';
    // filename for export
    $csv_filename = 'db_export_' . $db_record . '_' . date('Y-m-d') . '.csv';
    // database variables
    $hostname = $GLOBALS['server'];
    $user = $GLOBALS['username'];
    $password = $GLOBALS['password'];
    $database = $GLOBALS['db'];
    $port = 3306;

    $conn = mysqli_connect($hostname, $user, $password, $database, $port);
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    // create empty variable to be filled with export data
    $csv_export = '';

    // query to get data from database
    $query = mysqli_query($conn, "SELECT * FROM " . $db_record . " " . $where);
    $field = mysqli_field_count($conn);

    // create line with field names
    for ($i = 0; $i < $field; $i++) {
        $csv_export .= mysqli_fetch_field_direct($query, $i)->name . ';';
    }

    // newline (seems to work both on Linux & Windows servers)
    $csv_export .= '
';

    // loop through database query and fill export variable
    while ($row = mysqli_fetch_array($query)) {
        // create line with field values
        for ($i = 0; $i < $field; $i++) {
            $csv_export .= '"' . $row[mysqli_fetch_field_direct($query, $i)->name] . '";';
        }
        $csv_export .= '
';
    }


    file_put_contents($csv_filename, $csv_export);



    $asli = realpath($csv_filename);

    $cf = new CURLFile($asli);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$token/sendDocument");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        [
            "chat_id" => $chat_id,
            "document" => $cf,
        ]
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    unlink($csv_filename);
}
function csv_to_associative_array($file, $delimiter = ',', $enclosure = '"')
{
    if (($handle = fopen($file, "r")) !== false) {
        $headers = fgetcsv($handle, 0, $delimiter, $enclosure);
        $lines = [];
        while (($data = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false) {
            $current = [];
            $i = 0;
            foreach ($headers as $header) {
                $current[$header] = $data[$i++];
            }
            $lines[] = $current;
        }
        fclose($handle);
        return $lines;
    }
}
function req_post($link, $post)
{
    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.pasino.com/' . $link,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode($post),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_COOKIEJAR => 'coker_log',
            CURLOPT_COOKIEFILE => 'coker_log',
        )
    );
    $cx = curl_exec($ch);
    return $cx;
    curl_close($ch);
}

function loginkok($user, $pass)
{
    $post = array(
        'user' => $user,
        'password' => $pass . '',
        'api_key' => '2cb5e564b3bd7ab797a858d5e87b781a0004d54c6bc2fbedcfee3d6114853699',
    );

    $result_ = json_decode(req_post('api/login', $post), true);
    if ($result_['success'] == true) {

        $result['success'] = $result_['success'];
        $result['token'] = $result_['token'];
        $result['message'] = $result_['message'];
        $result['2fa_required'] = $result_['2fa_required'];
    } else {

        $result = array(
            'success' => false,
            'message' => $result_['message']
        );
    }
    return $result;
}
