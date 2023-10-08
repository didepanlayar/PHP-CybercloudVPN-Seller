<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login() {
    if (isset($_SESSION['token'])) {
        header('Location: ./');
        exit();
    }
}

function get_session() {
    if (!isset($_SESSION['token'])) {
        header('Location: login.php');
        exit();
    }
}