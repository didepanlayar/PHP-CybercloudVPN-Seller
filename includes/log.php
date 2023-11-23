<?php

function write_log($log_name, $response_send) {
    $today = date("Y-m-d H:i:s");
    $folderPath = '../logs';
    $filePath = $folderPath . '/service.log';

    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0755, true);
    }

    if (!file_exists($filePath)) {
        $file = fopen($filePath, 'w');
        fclose($file);
    }

    $dataToWrite = "$today INFO: $log_name $response_send\n";
    file_put_contents($filePath, $dataToWrite, FILE_APPEND);
}

?>
