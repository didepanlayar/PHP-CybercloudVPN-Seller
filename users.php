<?php

require_once 'includes/session.php';
require_once 'includes/config.php';
require_once 'includes/status.php';

get_session();

$title = 'Users';

include 'header.php';
include 'sidebar.php';

?>
            <div class="main-wrapper">
                <?php status_message(); ?>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <?php

                                $get_user = "SELECT * FROM users LIMIT 1";
                                $statement = mysqli_prepare($connect, $get_user);
                                mysqli_stmt_execute($statement);
                                $result = mysqli_stmt_get_result($statement);

                                if($row = mysqli_fetch_assoc($result)) {
                                    $user_name  = $row['user_name'];
                                    $user_email = $row['user_email'];
                                }

                                mysqli_close($connect);

                                ?>
                                <form action="includes/controller.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="user-name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="user-name" name="user-name" placeholder="John Doe" value="<?php echo $user_name; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="user-email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="user-email" name="user-email" placeholder="johndoe@email.com" value="<?php echo $user_email; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="authentication" class="form-label">Authentication</label>
                                            <input type="password" class="form-control" id="authentication" name="authentication" placeholder="**********" disabled>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="btn-change-password">Change Password</button>
                                        <button type="submit" class="btn btn-primary" name="save-users">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>