<body>
    <div class="page-container">
        <div class="page-sidebar">
            <a class="logo" href="<?php echo $data['siteurl']; ?>"><?php echo $data['sitename']; ?></a>
            <ul  class="list-unstyled accordion-menu">
                <li><a href="<?php echo $data['siteurl']; ?>"><i data-feather="home"></i>Dashboard</a></li>
                <li><a href="<?php echo $data['siteurl']; ?>/servers.php"><i data-feather="server"></i>Servers</a></li>
                <li>
                    <a href="#"><i data-feather="shopping-cart"></i>Orders<i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                        <li><a href="<?php echo $data['siteurl']; ?>/orders.php"><i class="fa fa-caret-right"></i>All Orders</li>
                        <li><a href="<?php echo $data['siteurl']; ?>/renew.php"><i class="fa fa-caret-right"></i>Renew</li>
                    </ul>
                </li>
                <li><a href="<?php echo $data['siteurl']; ?>/users.php"><i data-feather="users"></i>Users</a></li>
                <li><a href="<?php echo $data['siteurl']; ?>/settings.php"><i data-feather="settings"></i>Settings</a></li>
            </ul>
            <a href="#" id="sidebar-collapsed-toggle"><i data-feather="arrow-right"></i></a>
        </div>
        <div class="page-content">
            <div class="page-header">
                <nav class="navbar navbar-expand-lg d-flex justify-content-between">
                    <div class="header-title flex-fill">
                        <a href="#" id="sidebar-toggle"><i data-feather="arrow-left"></i></a>
                        <h5><?php echo $title; ?></h5>
                    </div>
                    <div class="flex-fill" id="headerNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"><i data-feather="log-out"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
