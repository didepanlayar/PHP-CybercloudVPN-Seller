<?php

$serverhost   = "localhost";
$username     = "root";
$password     = "root";
$database     = "database_name";

$connection = mysqli_connect($serverhost, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql_setting   = "SELECT setting_name, setting_value FROM settings";
$query_setting = mysqli_prepare($connection, $sql_setting);
mysqli_stmt_execute($query_setting);
$result = mysqli_stmt_get_result($query_setting);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['setting_name']] = $row['setting_value'];
}

mysqli_stmt_close($query_setting);