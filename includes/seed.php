<?php

require_once 'config.php';

$user_name  = 'Demo';
$user_email = 'demo@email.com';
$user_token = 'demo';

$get_user = "SELECT user_id FROM users WHERE user_name = ? AND user_email = ?";
$statement = mysqli_prepare($connect, $get_user);
mysqli_stmt_bind_param($statement, 'ss', $user_name, $user_email);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

if(mysqli_num_rows($result) == 0) {
    $hash_token = password_hash($user_token, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (user_name, user_email, user_token) VALUES (?, ?, ?)";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($statement, 'sss', $user_name, $user_email, $hash_token);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    header('Location: ../');
    exit();
}

mysqli_close($connect);

?>