<?php

session_start();

require_once 'config.php';

if(isset($_POST['login'])) {
    $authentication = $_POST['authentication'];
    $get_token = "SELECT user_token FROM users LIMIT 1";
    $statement = mysqli_prepare($connect, $get_token);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if($row = mysqli_fetch_assoc($result)) {
        $token = $row['user_token'];
        if(password_verify($authentication, $token)) {
            session_start();
            $_SESSION['token'] = true;
            header('Location: ../');
            exit();
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['status_message'] = 'The token you entered is incorrect.';
            header('Location: ../login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 'info';
        $_SESSION['status_message'] = 'Please contact the administrator.';
        header('Location: ../login.php');
        exit();
    }

    mysqli_close($connect);
}