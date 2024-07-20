<?php

require_once 'config.php';
require_once 'session.php';
require_once 'bot.php';

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

if (isset($_POST['upload-server'])) {
    $file_server = $_FILES["file-server"]["tmp_name"];

    require '../vendor/autoload.php';

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_server);
    $worksheet   = $spreadsheet->getActiveSheet();

    $sql_delete_server = "DELETE FROM servers";
    if (mysqli_query($connection, $sql_delete_server)) {
        $sql_server_increment = "ALTER TABLE servers AUTO_INCREMENT = 1";
        mysqli_query($connection, $sql_server_increment);

        $firstRow = true;

        foreach ($worksheet->getRowIterator() as $row) {
            if ($firstRow) {
                $firstRow = false;
                continue;
            }

            $data   = $row->getcellIterator();
            $values = array();

            foreach ($data as $cell) {
                $values[] = $cell->getValue();
            }

            $sql_server   = "INSERT INTO servers (server_type, server_name, server_host, server_interval, server_contact, server_keyword, server_keyword_value, server_port) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $query_server = mysqli_prepare($connection, $sql_server);
            mysqli_stmt_bind_param($query_server, 'sssisssi', $values[0], $values[1], $values[2], $values[3], $values[4], $values[5], $values[6], $values[7]);

            if (mysqli_stmt_execute($query_server)) {
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Server uploaded.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = mysqli_error($connection);
            }
        }
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['status_message'] = mysqli_error($connection);
    }

    mysqli_close($connection);

    header('Location: ../servers.php');
    exit();
}

if (isset($_POST['send-create'])) {
    $protocol       = $_POST['protocol'];
    $name           = $_POST['name'];
    $phone          = $_POST['whatsapp'];
    $server_name    = $_POST['server-name'];
    $host           = $_POST['host'];
    $expired        = $_POST['expired'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $payload_cdn    = $_POST['payload-cdn'];
    $payload_path   = $_POST['payload-path'];
    $vmess_uuid     = $_POST['vmess-uuid'];
    $vmess_tls      = $_POST['vmess-tls'];
    $vmess_ntls     = $_POST['vmess-ntls'];
    $vless_uuid     = $_POST['vless-uuid'];
    $vless_tls      = $_POST['vless-tls'];
    $vless_ntls     = $_POST['vless-ntls'];
    $key            = $_POST['key'];
    $trojan_tls     = $_POST['trojan-tls'];
    $today_date     = date("Y-m-d");
    $today_time     = date("H:i:s");
    $today_unique   = strtotime($today_date . ' ' . $today_time);

    if ($protocol == 'create-ssh') {
        $get_protocol = 'SSH & OpenVPN';
        $new_message  = "Informasi Akun VPN Premium Cybercloud VPN\n\n$get_protocol\nServer: $server_name\nHost: $host\nWebsocket SSL: 443\nWebsocket HTTP: 80\nUsername: $username\nPassword: $password\nExpired: $expired\n\nPayload CDN:\n$payload_cdn\n\nPayload Path:\n$payload_path\n\nTerima kasih telah menggunakan layanan kami.";
    } elseif ($protocol == 'create-vmess') {
        $get_protocol = 'Vmess';
        $new_message  = "Informasi Akun VPN Premium Cybercloud VPN\n\n$get_protocol\nServer: $server_name\nRemarks: $username\nHost: $host\nPort TLS: 443\nPort None TLS: 80\nUUID: $vmess_uuid\nAlterID: 0\nSecurity: auto\nNetwork: ws\nPath: /vmess\nMulti Path: /yourbug\nExpired: $expired\n\nConfig TLS:\n$vmess_tls\n\nConfig None TLS:\n$vmess_ntls\n\nTerima kasih telah menggunakan layanan kami.";
    } elseif ($protocol == 'create-vless') {
        $get_protocol = 'Vless';
        $new_message  = "Informasi Akun VPN Premium Cybercloud VPN\n\n$get_protocol\nServer: $server_name\nRemarks: $username\nHost: $host\nPort TLS: 443\nPort None TLS: 80\nUUID: $vless_uuid\nAlterID: 0\nSecurity: auto\nNetwork: ws\nPath: /vmess\nMulti Path: /yourbug\nExpired: $expired\n\nConfig TLS:\n$vless_tls\n\nConfig None TLS:\n$vless_ntls\n\nTerima kasih telah menggunakan layanan kami.";
    } elseif ($protocol == 'create-trojan') {
        $get_protocol = 'Trojan';
        $new_message  = "Informasi Akun VPN Premium Cybercloud VPN\n\n$get_protocol\nServer: $server_name\nRemarks: $username\nHost: $host\nPort: 443\nKey: $key\nNetwork: ws\nPath: /trojan\nMulti Path: /yourbug/trojan\nExpired: $expired\n\nConfig TLS:\n$trojan_tls\n\nTerima kasih telah menggunakan layanan kami.";
    }

    $bot_message  = "Pembelian Akun VPN Premium berhasil.\n\n$get_protocol\nServer: $server_name\nHost: **********\nUsername: $username\nExpired: $expired\n\nTerima kasih telah menggunakan layanan Cybercloud VPN.";
    $status       = 1;

    $sql_order   = "INSERT INTO orders (order_id, order_protocol, order_name, order_phone, order_server, order_host, order_username, order_status, order_created, order_expired) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $query_order = mysqli_prepare($connection, $sql_order);
    mysqli_stmt_bind_param($query_order, 'isssssssss', $today_unique, $get_protocol, $name, $phone, $server_name, $host, $username, $status, $today_date, $expired);

    if (mysqli_stmt_execute($query_order)) {
        $sql_history   = "INSERT INTO histories (order_id, order_status, history_date) VALUES (?, ?, ?)";
        $query_history = mysqli_prepare($connection, $sql_history);
        mysqli_stmt_bind_param($query_history, 'iis', $today_unique, $status, $today_date);
        mysqli_stmt_execute($query_history);
        mysqli_stmt_close($query_history);
        send_user($name, $phone, $new_message, $data);
        send_group($name, $phone, $bot_message, $data);
        $_SESSION['status'] = 'success';
        $_SESSION['status_message'] = 'Order completed.';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['status_message'] = $mysqli_error($connection);
    }

    mysqli_close($connection);

    header('Location: ../create.php');
    exit();
}

if (isset($_POST['send-renew'])) {
    $id             = $_POST['order-id'];
    $protocol       = $_POST['protocol'];
    $name           = $_POST['name'];
    $phone          = $_POST['whatsapp'];
    $server         = $_POST['server'];
    $host           = $_POST['host'];
    $username       = $_POST['username'];
    $status         = 2;
    $expired        = $_POST['expired'];
    $new_message    = "Masa aktif akun VPN Premium anda berhasil diperpanjang, berikut adalah informasi akun anda:\n\n$protocol\nServer: $server\nHost: $host\nUsername: $username\nExpired: $expired\n\nTerima kasih telah menggunakan layanan Cybercloud VPN.";
    $bot_message    = "Akun VPN Premium berhasil diperbarui.\n\n$protocol\nServer: $server\nHost: **********\nUsername: $username\nExpired: $expired\n\nTerima kasih telah menggunakan layanan Cybercloud VPN.";
    $today_date     = date("Y-m-d");

    if ($id) {
        $sql_renew   = "UPDATE orders SET order_status = ?, order_modified = ?, order_expired = ? WHERE order_id = ?";
        $query_renew = mysqli_prepare($connection, $sql_renew);
        mysqli_stmt_bind_param($query_renew, 'issi', $status, $today_date, $expired, $id);

        if (mysqli_stmt_execute($query_renew)) {
            $sql_history   = "INSERT INTO histories (order_id, order_status, history_date) VALUES (?, ?, ?)";
            $query_history = mysqli_prepare($connection, $sql_history);
            mysqli_stmt_bind_param($query_history, 'iis', $id, $status, $today_date);
            mysqli_stmt_execute($query_history);
            mysqli_stmt_close($query_history);
            send_user($name, $phone, $new_message, $data);
            send_group($name, $phone, $bot_message, $data);
            $_SESSION['status'] = 'success';
            $_SESSION['status_message'] = 'Order updated.';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['status_message'] = mysqli_error($connection);
        }
    }

    mysqli_close($connection);

    header('Location: ../renew.php');
    exit();
}

if (isset($_POST['send-delete'])) {
    $id             = $_POST['order-id'];

    $sql_orders  = "SELECT * FROM orders WHERE order_id = ?";
    $query_orders = mysqli_prepare($connection, $sql_orders);
    mysqli_stmt_bind_param($query_orders, 'i', $id);
    mysqli_stmt_execute($query_orders);
    $result = mysqli_stmt_get_result($query_orders);
    $row    = mysqli_fetch_assoc($result);

    if ($row) {
        $protocol       = $row['order_protocol'];
        $name           = $row['order_name'];
        $phone          = $row['order_phone'];
        $server         = $row['order_server'];
        $username       = $row['order_username'];
        $status         = 0;
        $expired        = $row['order_expired'];
        $bot_message    = "Akun VPN Premium berhasil dihapus.\n\n$protocol\nServer: $server\nHost: **********\nUsername: $username\nExpired: $expired\n\nTerima kasih telah menggunakan layanan Cybercloud VPN.";
        $today_date     = date("Y-m-d");

        $sql_delete   = "UPDATE orders SET order_status = ?, order_modified = ? WHERE order_id = ?";
        $query_delete = mysqli_prepare($connection, $sql_delete);
        mysqli_stmt_bind_param($query_delete, 'isi', $status, $today_date, $id);

        if (mysqli_stmt_execute($query_delete)) {
            $sql_history   = "INSERT INTO histories (order_id, order_status, history_date) VALUES (?, ?, ?)";
            $query_history = mysqli_prepare($connection, $sql_history);
            mysqli_stmt_bind_param($query_history, 'iis', $id, $status, $today_date);
            mysqli_stmt_execute($query_history);
            mysqli_stmt_close($query_history);
            send_group($name, $phone, $bot_message, $data);
            $_SESSION['status'] = 'success';
            $_SESSION['status_message'] = 'Order deleted.';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['status_message'] = mysqli_error($connection);
        }
    }

    mysqli_close($connection);

    header('Location: ../orders.php');
    exit();
}