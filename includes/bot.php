<?php

require_once 'config.php';
require_once 'log.php';

function send_user($name, $phone, $new_message, $data) {
    $log_name = '[User]';
    // WhatsApp: User
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
            'message' => $new_message, 
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

function send_group($name, $phone, $bot_message, $data) {

    $log_name = '[Group]';

    // WhatsApp: Group
    $curl_whatsapp = curl_init();
    curl_setopt_array($curl_whatsapp, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $data['wachatid'],
            'message' => $bot_message, 
            'delay' => '2', 
            'countryCode' => '62',
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $data['watoken']
        ),
    ));
    $response_send = curl_exec($curl_whatsapp);
    curl_close($curl_whatsapp);
    write_log($log_name, $response_send);

    // Telegram: Group
    $curl_telegram = curl_init();
    curl_setopt_array($curl_telegram, array(
        CURLOPT_URL => 'https://api.telegram.org/bot' . $data['tgtoken'] . '/sendMessage',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(array(
            'chat_id' => $data['tgchatid'],
            'text' => $bot_message,
        )),
    ));
    $response_send = curl_exec($curl_telegram);
    curl_close($curl_telegram);
    write_log($log_name, $response_send);
}

?>