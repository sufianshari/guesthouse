<header class="main-header">
    <a href="<?php echo base_url(); ?>dashboard/" class="logo">
        <span class="logo-mini"><i class="fa fa-home"></i></span>
        <span class="logo-lg"><i class="fa fa-home"></i> Administrator</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url(); ?>home/" target="_blank"><i class="fa fa-globe"></i> Front Website</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs">User Login</span>&nbsp;
                        <i class="fa fa-chevron-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>dashboard/change_password"><i class="fa fa-refresh"></i> Ganti Password</a></li>
                        <li><a href="<?php echo base_url(); ?>dashboard/logout"><i class="fa fa-lock"></i> Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>