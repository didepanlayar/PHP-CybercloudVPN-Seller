<?php

$serverhost   = "mariadb";
$username     = "root";
$password     = "root";
$database     = "db_sellervpn";

$connect = mysqli_connect($serverhost, $username, $password, $database);

if(!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}