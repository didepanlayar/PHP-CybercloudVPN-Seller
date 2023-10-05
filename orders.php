<?php

require_once 'includes/session.php';

get_session();

$title = 'Orders';

include 'header.php';
include 'sidebar.php';

$sql_orders  = "SELECT * FROM orders";
$query_orders = mysqli_prepare($connection, $sql_orders);
mysqli_stmt_execute($query_orders);
$result = mysqli_stmt_get_result($query_orders);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
                                <a href="<?php echo $data['siteurl']; ?>/create.php" class="btn btn-outline-primary btn-sm m-b-md"><i class="fa fa-plus"></i> Create</a>
                                <table id="table-server" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Host</th>
                                            <th>Protocol</th>
                                            <th>status</th>
                                            <th>Expired</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order) : ?>
                                            <tr>
                                                <td><?php echo $order['order_username']; ?></td>
                                                <td><?php echo $order['order_server']; ?></td>
                                                <td><?php echo $order['order_protocol']; ?></td>
                                                <td>
                                                    <?php if ($order['order_status'] == 1) : ?>
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    <?php elseif ($order['order_status'] == 2) : ?>
                                                        <span class="badge rounded-pill bg-info">Renew</span>
                                                    <?php else : ?>
                                                        <span class="badge rounded-pill bg-danger">Deactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $order['order_expired']; ?></td>
                                                <td>
                                                    <a href="renew.php?id=<?php echo $order['order_id']; ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-retweet"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>