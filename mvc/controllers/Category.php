<?php
    class Category extends Connect{
        function index(){
            // load giao diện trang chủ home/main.php
            $data['main'] = 'category/main';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
    }
?>