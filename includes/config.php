<?php

$serverhost   = "localhost";
$username     = "root";
$password     = "root";
$database     = "database_name";

$connect = mysqli_connect($serverhost, $username, $password, $database);

if(!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}