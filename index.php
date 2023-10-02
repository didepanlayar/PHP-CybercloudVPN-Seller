<?php

require_once 'includes/session.php';

get_session();

$title = 'Dashboard';

include 'header.php';
include 'sidebar.php';

?>
            <div class="main-wrapper">
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <h1>Welcome</h1>
                            <h2>Cybercloud VPN</h2>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'footer.php'; ?>