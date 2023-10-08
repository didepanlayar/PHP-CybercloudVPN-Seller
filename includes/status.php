<?php

require_once 'session.php';

function status_message() {
    if (isset($_SESSION['status_message'])) {
        $status_message = $_SESSION['status_message'];

        if (isset($_SESSION['status']) && $_SESSION['status'] === 'success') {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> ' . $status_message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        elseif (isset($_SESSION['status']) && $_SESSION['status'] === 'error') {
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> ' . $status_message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        elseif (isset($_SESSION['status']) && $_SESSION['status'] === 'info') {
            echo '
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Info!</strong> ' . $status_message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

    unset($_SESSION['status']);
    unset($_SESSION['status_message']);
    }
}

?>