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

if(isset($_POST['save-users'])) {
    $get_id             = 1;
    $get_name           = $_POST['user-name'];
    $get_email          = $_POST['user-email'];
    $get_authentication = $_POST['authentication'];

    $query = "SELECT * FROM users WHERE user_id = ?";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($statement, 'i', $get_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);

    if (mysqli_stmt_num_rows($statement) === 0) {
        $_SESSION['status'] = 'error';
        $_SESSION['status_message'] = 'User not found.';
        header('Location: ../users.php');
        exit();
    }

    if(!empty($get_name)) {
        $query = "UPDATE users SET user_name = ? WHERE user_id = ?";
        $statement = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($statement, 'si', $get_name, $get_id);
        if(mysqli_stmt_execute($statement)) {
            mysqli_stmt_close($statement);
            $_SESSION['status'] = 'success';
            $_SESSION['status_message'] = 'Name updated.';
            header('Location: ../users.php');
            exit();
        } else {
            die("Error! " . mysqli_error($connect));
        }
    }

    if(!empty($get_email)) {
        $query = "UPDATE users SET user_email = ? WHERE user_id = ?";
        $statement = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($statement, 'si', $get_email, $get_id);
        if(mysqli_stmt_execute($statement)) {
            mysqli_stmt_close($statement);
            $_SESSION['status'] = 'success';
            $_SESSION['status_message'] = 'Email updated.';
            header('Location: ../users.php');
            exit();
        } else {
            die("Error! " . mysqli_error($connect));
        }
    }

    if(!empty($get_authentication)) {
        $hash_token = password_hash($get_authentication, PASSWORD_BCRYPT);
        $query = "UPDATE users SET user_token = ? WHERE user_id = ?";
        $statement = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($statement, 'si', $hash_token, $get_id);
        if(mysqli_stmt_execute($statement)) {
            mysqli_stmt_close($statement);
            $_SESSION['status'] = 'success';
            $_SESSION['status_message'] = 'Password updated.';
            header('Location: ../users.php');
            exit();
        } else {
            die("Error! " . mysqli_error($connect));
        }
    }

    mysqli_close($connect);
}