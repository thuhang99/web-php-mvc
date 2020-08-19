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
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php 
                    $arr = array(
                        'Admin' =>  array(
                            'name' => 'Bảng điều khiển',
                            'icon' => 'tachometer-alt'
                        ),
                        'Product' =>  array(
                            'name' => 'Sản phẩm',
                            'icon' => 'th'
                        ),
                        'Category' =>  array(
                            'name' => 'Danh mục',
                            'icon' => 'copy'
                        ),
                        'User' =>  array(
                            'name' => 'Thành viên',
                            'icon' => 'chart-pie'
                        )
                    );
                    $url = explode('/', $_GET['url']);

                    $url_active = '';

                    if(isset($url[0]))
                    {
                        $url_active = $url[0];
                    }
                ?>
                <?php 
                    foreach ($arr as $key => $value) {   
                        if($key == $url_active )
                        {
                            $active = 'active';
                        }
                        else {
                            $active = '';
                        }
                ?>
            <li class="nav-item has-treeview">
                <a href="<?php echo URL.$key; ?>" class="nav-link <?php echo $active; ?>">
                    <i class="nav-icon fas fa-<?php echo $value['icon'] ?>"></i>
                    <p>
                    <?php echo $value['name']; ?>
                    </p>
                 </a>   
            </li>
            <?php 
                    }
            ?>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>