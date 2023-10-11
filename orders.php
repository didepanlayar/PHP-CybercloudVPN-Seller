<?php

require_once 'includes/session.php';

get_session();

$title = 'Orders';

include 'header.php';
include 'sidebar.php';

$sql_orders  = "SELECT * FROM orders WHERE order_status != 0 ORDER BY order_id DESC";
$query_orders = mysqli_prepare($connection, $sql_orders);

if (mysqli_stmt_execute($query_orders)) { 
    $result = mysqli_stmt_get_result($query_orders);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                                <a href="create.php" class="btn btn-outline-primary btn-sm m-b-md"><i class="fa fa-plus"></i> Create</a>
                                <a href="history.php" class="btn btn-outline-success btn-sm m-b-md"><i class="fa fa-history"></i> History</a>
                                <table id="table-server" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Protocol</th>
                                            <th>Host</th>
                                            <th>status</th>
                                            <th>Expired</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($orders) : foreach ($orders as $order) : ?>
                                            <tr>
                                                <td><?php echo $order['order_username']; ?></td>
                                                <td><?php echo $order['order_protocol']; ?></td>
                                                <td><?php echo $order['order_server']; ?></td>
                                                <td>
                                                    <?php if ($order['order_status'] == 1) : ?>
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    <?php elseif ($order['order_status'] == 2) : ?>
                                                        <span class="badge rounded-pill bg-info">Update</span>
                                                    <?php else : ?>
                                                        <span class="badge rounded-pill bg-danger">Deactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $order['order_expired']; ?></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#view-<?php echo $order['order_id']; ?>"><i class="fa fa-eye"></i></button>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <form action="renew.php" method="POST">
                                                                <input type="hidden" name="id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="submit" class="btn btn-outline-primary btn-sm" name="send-renew"><i class="fa fa-retweet"></i></button>
                                                            </form>
                                                        </div>
                                                        <div class="col-4 col-md-4 col-sm-4">
                                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-<?php echo $order['order_id']; ?>"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="view-<?php echo $order['order_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ModalCenterTitle">Detail</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="order-id" class="col-sm-4 col-form-label">Order ID</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="order-id" name="order-id" value="<?php echo $order['order_id']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="protocol" class="col-sm-4 col-form-label">Protocol</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="protocol" value="<?php echo $order['order_protocol']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-4 col-form-label">Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $order['order_name']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="whatsapp" class="col-sm-4 col-form-label">WhatsApp</label>
                                                                <div class="col-sm-8">
                                                                    <input type="number" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $order['order_phone']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="server" class="col-sm-4 col-form-label">Server</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="server" name="server" value="<?php echo $order['order_server']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="host" class="col-sm-4 col-form-label">Host/IP</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="host" name="host" value="<?php echo $order['order_host']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="username" class="col-sm-4 col-form-label">Username</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $order['order_username']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="expired" class="col-sm-4 col-form-label">Expired</label>
                                                                <div class="col-sm-8">
                                                                    <input type="date" class="form-control" id="expired" name="expired" value="<?php echo $order['order_expired']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete-<?php echo $order['order_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="ModalCenterTitle">Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete user <strong><?php echo $order['order_username']; ?></strong>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="includes/controller.php" method="POST">
                                                                <input type="hidden" id="order-id" name="order-id" value="<?php echo $order['order_id']; ?>">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger btn-sm" name="send-delete">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>