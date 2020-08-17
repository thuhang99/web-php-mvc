<?php
    class Admin extends Connect{
        function index(){
           $data['main']='home/content';
           $this->load_views('admin/index',$data);
        }

    }
?>