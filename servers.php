<?php

require_once 'includes/session.php';

get_session();

$title = 'Servers';

include 'header.php';
include 'sidebar.php';

$sql_servers  = "SELECT server_name, server_host, server_interval, server_port FROM servers";
$query_server = mysqli_prepare($connection, $sql_servers);
mysqli_stmt_execute($query_server);
$result = mysqli_stmt_get_result($query_server);

$servers = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
                                <button type="button" class="btn btn-outline-primary m-b-md" data-bs-toggle="modal" data-bs-target="#upload-server"><i class="fa fa-upload"></i> Upload Server</button>
                                <table id="table-server" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Host</th>
                                            <th>Interval</th>
                                            <th>Port</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($servers as $server) : ?>
                                            <tr>
                                                <td><?php echo $server['server_name']; ?></td>
                                                <td><?php echo $server['server_host']; ?></td>
                                                <td><?php echo $server['server_interval']; ?></td>
                                                <td><?php echo $server['server_port']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="upload-server" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalCenterTitle">Upload Server</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="includes/controller.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <p>You should upload a file that includes about server. The file type must be <strong>.xlsx</strong> or <strong>.csv</strong></p>
                                            <input type="file" class="form-control" id="file-server" name="file-server">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="upload-server">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>