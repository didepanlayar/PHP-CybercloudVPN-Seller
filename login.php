<?php

require_once 'includes/session.php';

login();

$title = 'Login';

include 'header.php';

?>
<body class="login-page">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div class="card login-box-container">
                    <div class="card-body">
                        <div class="authent-logo">
                            <a href="<?php echo $base_url; ?>">Cybercloud VPN</a>
                        </div>
                        <div class="authent-text">
                            <p>Welcome to Cybercloud VPN</p>
                            <p>Please Sign-in to your account.</p>
                        </div>
                        <?php if(isset($_SESSION['status']) && $_SESSION['status'] === 'error') : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> The token you entered is incorrect.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php elseif(isset($_SESSION['status']) && $_SESSION['status'] === 'wrong') : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Please contact the administrator.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; unset($_SESSION['status']); ?>
                        <form action="includes/controller.php" method="POST">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="authentication" placeholder="Token">
                                    <label for="authentication">Authentication</label>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info m-b-xs" name="login">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>