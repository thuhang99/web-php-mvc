<?php
    class User extends Connect{
        function index(){
            // load giao diện trang chủ home/main.php
            $data['main'] = 'user/main';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
    }
?>