<?php

require_once 'includes/session.php';

get_session();

$title = 'Renew';

include 'header.php';
include 'sidebar.php';

if (isset($_REQUEST['id'])) {
    $order_id = $_REQUEST['id'];

    $sql_get_order   = "SELECT * FROM orders WHERE order_id = ?";
    $query_get_order = mysqli_prepare($connection, $sql_get_order);
    mysqli_stmt_bind_param($query_get_order, 'i', $order_id);
    mysqli_stmt_execute($query_get_order);
    $result = mysqli_stmt_get_result($query_get_order);
    $row    = mysqli_fetch_assoc($result);

    if ($row) {
        $get_protocol = $row['order_protocol'];
        $get_name     = $row['order_name'];
        $get_phone    = $row['order_phone'];
        $get_host     = $row['order_host'];
        $get_expired  = $row['order_expired'];
        $get_username = $row['order_username'];
    }
}

?>
            <div class="main-wrapper">
                <?php if (isset($_SESSION['status'])) : ?>
                    <div class="row px-5 row-close">
                        <div class="col">
                            <?php status_message(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form action="includes/controller.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="protocol" class="form-label">Protocol</label>
                                            <select class="form-select" name="protocol" <?php if (isset($_REQUEST['id'])) { echo 'disabled'; } ?> required>
                                                <option value="">Select Protocol</option>
                                                <?php if ($get_protocol == 'SSH & OpenVPN') : ?>
                                                    <option value="renew-ssh" selected="">SSH & OpenVPN</option>
                                                <?php elseif ($get_protocol == 'Vmess') : ?>
                                                    <option value="renew-vmess" selected="">Vmess</option>
                                                <?php elseif ($get_protocol == 'Vless') : ?>
                                                    <option value="renew-vless" selected="">Vless</option>
                                                <?php elseif ($get_protocol == 'Trojan') : ?>
                                                    <option value="renew-trojan" selected="">Trojan</option>
                                                <?php else : ?>
                                                    <option value="renew-ssh">SSH & OpenVPN</option>
                                                    <option value="renew-vmess">Vmess</option>
                                                    <option value="renew-vless">Vless</option>
                                                    <option value="renew-trojan">Trojan</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" value="<?php echo $get_name; ?>" <?php if (isset($_REQUEST['id'])) { echo 'disabled'; } ?> required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="whatsapp" class="form-label">WhatsApp</label>
                                            <input type="number" class="form-control" id="whatsapp" name="whatsapp" placeholder="08123456789" value="<?php echo $get_phone; ?>" <?php if (isset($_REQUEST['id'])) { echo 'disabled'; } ?> onkeypress="return setNumber(event)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="host" class="form-label">Host/IP</label>
                                            <input type="text" class="form-control" id="host" name="host" placeholder="domain.com" value="<?php echo $get_host; ?>" <?php if (isset($_REQUEST['id'])) { echo 'disabled'; } ?> required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expired" class="form-label">Expired</label>
                                            <input type="date" class="form-control" id="expired" name="expired" value="<?php echo $get_expired; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="johndoe" value="<?php echo $get_username; ?>" <?php if (isset($_REQUEST['id'])) { echo 'disabled'; } ?> required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="send-renew">Renew</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>