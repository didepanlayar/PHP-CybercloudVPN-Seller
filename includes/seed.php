<?php

require_once 'config.php';

$user_name  = 'Demo';
$user_email = 'demo@email.com';
$user_token = 'demo';

$sql_user_id   = "SELECT user_id FROM users WHERE user_name = ? AND user_email = ?";
$query_user_id = mysqli_prepare($connection, $sql_user_id);
mysqli_stmt_bind_param($query_user_id, 'ss', $user_name, $user_email);
mysqli_stmt_execute($query_user_id);
$result = mysqli_stmt_get_result($query_user_id);

if (mysqli_stmt_num_rows($query_user_id) == 0) {
    $hash_token = password_hash($user_token, PASSWORD_BCRYPT);

    $sql_user   = "INSERT INTO users (user_name, user_email, user_token) VALUES (?, ?, ?)";
    $query_user = mysqli_prepare($connection, $sql_user);
    mysqli_stmt_bind_param($query_user, 'sss', $user_name, $user_email, $hash_token);
    mysqli_stmt_execute($query_user);

    mysqli_stmt_close($query_user);
    $_SESSION['status'] = 'success';
    $_SESSION['status_message'] = 'User added.';

} else {
    $_SESSION['status'] = 'error';
    $_SESSION['status_message'] = mysqli_error($connection);
}

mysqli_close($connection);

header('Location: ../login.php');
exit();

?>