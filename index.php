<?php

require_once 'includes/session.php';

get_session();

$title = 'Dashboard';

include 'header.php';
include 'sidebar.php';

function get_order($connection, $protocol) {
    $sql_account = "SELECT COUNT(*) as total FROM orders WHERE order_protocol = '$protocol'";
    $query_account = mysqli_query($connection, $sql_account);

    if ($query_account) {
        $result = mysqli_fetch_assoc($query_account);
        return $result['total'];
    } else {
        return 0;
    }
}

$total_ssh    = get_order($connection, 'SSH & OpenVPN');
$total_vmess  = get_order($connection, 'Vmess');
$total_vless  = get_order($connection, 'Vless');
$total_trojan = get_order($connection, 'Trojan');

function get_active($connection, $protocol) {
    $sql_account = "SELECT COUNT(*) as active FROM orders WHERE order_protocol = '$protocol' AND order_status != 0";
    $query_account = mysqli_query($connection, $sql_account);

    if ($query_account) {
        $result = mysqli_fetch_assoc($query_account);
        return $result['active'];
    } else {
        return 0;
    }
}

$active_ssh    = get_active($connection, 'SSH & OpenVPN');
$active_vmess  = get_active($connection, 'Vmess');
$active_vless  = get_active($connection, 'Vless');
$active_trojan = get_active($connection, 'Trojan');

mysqli_close($connection);

?>
            <div class="main-wrapper">
                <div class="row px-3">
                    <div class="col-lg-3">
                        <div class="card card-bg">
                            <div class="card-body">
                                <div class="transactions-list">
                                    <div class="tr-item">
                                        <div class="tr-company-name">
                                            <div class="tr-icon tr-card-icon tr-card-bg-primary text-white">
                                                <i data-feather="terminal"></i>
                                            </div>
                                            <div class="tr-text">
                                                <h4 class="text-white">SSH & OpenVPN</h4>
                                                <p>Total: <?php echo $total_ssh; ?></p>
                                            </div>
                                        </div>
                                        <div class="tr-rate">
                                            <p><span class="text-success"><?php echo $active_ssh; ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-bg">
                            <div class="card-body">
                                <div class="transactions-list">
                                    <div class="tr-item">
                                        <div class="tr-company-name">
                                            <div class="tr-icon tr-card-icon tr-card-bg-success text-white">
                                                <i data-feather="cloud-rain"></i>
                                            </div>
                                            <div class="tr-text">
                                                <h4 class="text-white">Vmess</h4>
                                                <p>Total: <?php echo $total_vmess; ?></p>
                                            </div>
                                        </div>
                                        <div class="tr-rate">
                                            <p><span class="text-success"><?php echo $active_vmess; ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-bg">
                            <div class="card-body">
                                <div class="transactions-list">
                                    <div class="tr-item">
                                        <div class="tr-company-name">
                                            <div class="tr-icon tr-card-icon tr-card-bg-warning text-white">
                                                <i data-feather="cloud-drizzle"></i>
                                            </div>
                                            <div class="tr-text">
                                                <h4 class="text-white">Vless</h4>
                                                <p>Total: <?php echo $total_vless; ?></p>
                                            </div>
                                        </div>
                                        <div class="tr-rate">
                                            <p><span class="text-success"><?php echo $active_vless; ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-bg">
                            <div class="card-body">
                                <div class="transactions-list">
                                    <div class="tr-item">
                                        <div class="tr-company-name">
                                            <div class="tr-icon tr-card-icon tr-card-bg-info text-white">
                                                <i data-feather="shield"></i>
                                            </div>
                                            <div class="tr-text">
                                                <h4 class="text-white">Trojan</h4>
                                                <p>Total: <?php echo $total_trojan; ?></p>
                                            </div>
                                        </div>
                                        <div class="tr-rate">
                                            <p><span class="text-success"><?php echo $active_trojan; ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php include 'footer.php'; ?>