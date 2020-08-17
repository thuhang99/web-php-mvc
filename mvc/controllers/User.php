<?php
    class User extends Connect{
        function index(){
           $data['main']='user/main';
           
           $this->load_views('admin/index',$data);
        }

    }
?>