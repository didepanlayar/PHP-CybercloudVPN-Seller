<?php

require_once 'config.php';
require_once 'log.php';

$today = date("Y-m-d");

$sql_expired   = "SELECT order_protocol, order_name, order_phone, order_server, order_host, order_username, order_status, order_expired FROM orders WHERE order_expired = DATE_ADD('$today', INTERVAL 1 DAY) AND order_status != 0";
$query_expired = mysqli_query($connection, $sql_expired);

if ($query_expired) {
    while ($row = mysqli_fetch_assoc($query_expired)) {
        $log_name    = '[Reminder]';
        $protocol    = $row['order_protocol'];
        $name        = $row['order_name'];
        $phone       = $row['order_phone'];
        $server      = $row['order_server'];
        $host        = $row['order_host'];
        $username    = $row['order_username'];
        $expired     = $row['order_expired'];
        $exp_message = "Masa aktif akun VPN Premium anda akan segera berakhir, berikut adalah informasi akun anda:\n\n$protocol\nServer: $server\nHost: $host\nUsername: $username\nExpired: $expired\n\nUntuk perpanjang akun VPN Premium anda silahkan hubungi kami melalui WhatsApp atau Telegram.";

        // WhatsApp: Reminder
        $curl_send = curl_init();
        curl_setopt_array($curl_send, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => "$phone|$name",
                'message' => $exp_message, 
                'delay' => '2', 
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $data['watoken']
            ),
        ));
        $response_send = curl_exec($curl_send);
        curl_close($curl_send);
        write_log($log_name, $response_send);
    }
}

mysqli_close($connection);

?>