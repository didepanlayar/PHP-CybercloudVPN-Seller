<?php

require_once 'includes/session.php';

get_session();

$title = 'Histories';

include 'header.php';
include 'sidebar.php';

$sql_histories  = "SELECT h.history_date, o.order_username, o.order_protocol, o.order_server, h.order_status FROM histories h INNER JOIN orders o ON h.order_id = o.order_id ORDER BY h.history_id DESC";
$query_histories = mysqli_prepare($connection, $sql_histories);

if (mysqli_stmt_execute($query_histories)) { 
    $result = mysqli_stmt_get_result($query_histories);
    $histories = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                                <table id="table-server" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Username</th>
                                            <th>Server</th>
                                            <th>Protocol</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($histories) : foreach ($histories as $history) : ?>
                                            <tr>
                                                <td><?php echo $history['history_date']; ?></td>
                                                <td><?php echo $history['order_username']; ?></td>
                                                <td><?php echo $history['order_server']; ?></td>
                                                <td><?php echo $history['order_protocol']; ?></td>
                                                <td>
                                                    <center>
                                                        <?php if ($history['order_status'] == 1) : ?>
                                                            <span class="badge rounded-pill bg-success">Created</span>
                                                        <?php elseif ($history['order_status'] == 2) : ?>
                                                            <span class="badge rounded-pill bg-info">Updated</span>
                                                        <?php else : ?>
                                                            <span class="badge rounded-pill bg-danger">Deleted</span>
                                                        <?php endif; ?>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>