<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo URL; ?>" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
                <a href="<?php echo URL.'Admin'; ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Bảng điều khiển
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo URL.'Product'; ?>" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                    Sản phẩm
                    </p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="<?php echo URL.'Category'; ?>" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                    Danh mục
                    </p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="<?php echo URL.'User'; ?>" class="nav-link">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                    Thành viên
                    </p>
                </a>
            </li>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>