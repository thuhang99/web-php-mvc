<?php
    class Admin extends Connect{
        function index(){
            // load giao diện trang chủ home/main.php
            $data['main'] = 'home/content';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
    }
?>