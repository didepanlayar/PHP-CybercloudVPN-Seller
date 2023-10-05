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
                                                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#user-<?php echo $order['order_id']; ?>"><i class="fa fa-eye"></i></button>
                                                    <a href="renew.php?id=<?php echo $order['order_id']; ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-retweet"></i></a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="user-<?php echo $order['order_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ModalCenterTitle">Detail</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" class="form-control" value="<?php echo $order['order_name']; ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Server</label>
                                                                <input type="text" class="form-control" value="<?php echo $order['order_server']; ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Host</label>
                                                                <input type="text" class="form-control" value="<?php echo $order['order_host']; ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Username</label>
                                                                <input type="text" class="form-control" value="<?php echo $order['order_username']; ?>" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Expired</label>
                                                                <input type="date" class="form-control" value="<?php echo $order['order_expired']; ?>" disabled>
                                                            </div>
                                                        </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>