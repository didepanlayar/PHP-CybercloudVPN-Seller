<?php

require_once 'includes/config.php';
require_once 'includes/status.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo $data['siteurl']; ?>/assets/images/favicon.ico">
    <title><?php echo $data['sitetitle']; ?> - <?php echo $title; ?></title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo $data['siteurl']; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $data['siteurl']; ?>/assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="<?php echo $data['siteurl']; ?>/assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?php echo $data['siteurl']; ?>/assets/plugins/pace/pace.css" rel="stylesheet">
    <!-- Theme Styles -->
    <link href="<?php echo $data['siteurl']; ?>/assets/css/main.min.css" rel="stylesheet">
    <link href="<?php echo $data['siteurl']; ?>/assets/css/custom.css" rel="stylesheet">
</head>
