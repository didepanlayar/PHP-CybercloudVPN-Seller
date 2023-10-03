<?php

session_start();

require_once 'config.php';

if (isset($_POST['login'])) {
    $authentication = $_POST['authentication'];

    $sql_authentication = "SELECT user_token FROM users LIMIT 1";
    $query_authentication = mysqli_prepare($connection, $sql_authentication);

    if ($query_authentication) {
        mysqli_stmt_execute($query_authentication);
        $result = mysqli_stmt_get_result($query_authentication);

        if ($row = mysqli_fetch_assoc($result)) {
            $token = $row['user_token'];

            if (password_verify($authentication, $token)) {
                session_start();
                $_SESSION['token'] = true;
                header('Location: ../');
                exit();
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'The token you entered is incorrect.';
            }
        } else {
            $_SESSION['status'] = 'info';
            $_SESSION['status_message'] = 'Please contact the administrator.';
        }

        mysqli_stmt_close($query_authentication);
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['status_message'] = mysqli_error($connection);
    }

    mysqli_close($connection);

    header('Location: ../login.php');
    exit();
}

if (isset($_POST['save-users'])) {
    $user_id    = 1;
    $user_name  = $_POST['user-name'];
    $user_email = $_POST['user-email'];
    $user_token = $_POST['authentication'];

    $sql_users   = "SELECT user_name, user_email FROM users WHERE user_id = ?";
    $query_users = mysqli_prepare($connection, $sql_users);
    mysqli_stmt_bind_param($query_users, 'i', $user_id);
    mysqli_stmt_execute($query_users);
    mysqli_stmt_store_result($query_users);

    if (mysqli_stmt_num_rows($query_users) === 0) {
        $_SESSION['status'] = 'error';
        $_SESSION['status_message'] = 'User not found.';
    } else {
        mysqli_stmt_bind_result($query_users, $get_user_name, $get_user_email);
        mysqli_stmt_fetch($query_users);
        mysqli_autocommit($connection, false);

        if ($user_name !== $get_user_name) {
            $sql_user_name   = "UPDATE users SET user_name = ? WHERE user_id = ?";
            $query_user_name = mysqli_prepare($connection, $sql_user_name);
            mysqli_stmt_bind_param($query_user_name, 'si', $user_name, $user_id);

            if (mysqli_stmt_execute($query_user_name)) {
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Name updated.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = mysqli_error($connection);
            }
        }

        if ($user_email !== $get_user_email) {
            $sql_user_email   = "UPDATE users SET user_email = ? WHERE user_id = ?";
            $query_user_email = mysqli_prepare($connection, $sql_user_email);
            mysqli_stmt_bind_param($query_user_email, 'si', $user_email, $user_id);

            if (mysqli_stmt_execute($query_user_email)) {
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Email updated.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = mysqli_error($connection);
            }
        }
        
        if (!empty($user_token)) {
            $hash_token = password_hash($user_token, PASSWORD_BCRYPT);
        
            $sql_user_token   = "UPDATE users SET user_token = ? WHERE user_id = ?";
            $query_user_token = mysqli_prepare($connection, $sql_user_token);
            mysqli_stmt_bind_param($query_user_token, 'si', $hash_token, $user_id);
        
            if (mysqli_stmt_execute($query_user_token)) {
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Password updated.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = mysqli_error($connection);
            }
        }

        mysqli_commit($connection);
        mysqli_autocommit($connection, true);
        mysqli_close($connection);

        header('Location: ../users.php');
        exit();
    }
}

if (isset($_POST['save-settings'])) {
    $settings = [
        'sitetitle' => $_POST['site-title'],
        'sitename'  => $_POST['display-name'],
        'siteurl'   => $_POST['site-address'],
        'watoken'   => $_POST['whatsapp'],
        'wachatid'  => $_POST['wachatid'],
        'tgtoken'   => $_POST['telegram'],
        'tgchatid'  => $_POST['tgchatid']
    ];

    $updated_settings = [];

    foreach ($settings as $setting_name => $setting_value) {
        $sql_get_current_value   = "SELECT setting_value FROM settings WHERE setting_name = ?";
        $query_get_current_value = mysqli_prepare($connection, $sql_get_current_value);
        mysqli_stmt_bind_param($query_get_current_value, 's', $setting_name);
        mysqli_stmt_execute($query_get_current_value);
        mysqli_stmt_store_result($query_get_current_value);

        if (mysqli_stmt_num_rows($query_get_current_value) === 1) {
            mysqli_stmt_bind_result($query_get_current_value, $current_value);
            mysqli_stmt_fetch($query_get_current_value);

            if ($current_value !== $setting_value) {
                $updated_settings[$setting_name] = $setting_value;
            }
        }

        mysqli_stmt_close($query_get_current_value);
    }

    if (!empty($updated_settings)) {
        mysqli_autocommit($connection, false);

        foreach ($updated_settings as $setting_name => $setting_value) {
            $sql_update_setting   = "UPDATE settings SET setting_value = ? WHERE setting_name = ?";
            $query_update_setting = mysqli_prepare($connection, $sql_update_setting);
            mysqli_stmt_bind_param($query_update_setting, 'ss', $setting_value, $setting_name);

            if (mysqli_stmt_execute($query_update_setting)) {
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Settings updated.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = mysqli_error($connection);
                break;
            }

            mysqli_stmt_close($query_update_setting);
        }

        mysqli_commit($connection);
        mysqli_autocommit($connection, true);
    } else {
        $_SESSION['status'] = 'info';
        $_SESSION['status_message'] = 'No settings were updated.';
    }

    mysqli_close($connection);

    header('Location: ../settings.php');
    exit();
}