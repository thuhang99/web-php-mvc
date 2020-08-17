<?php
    class Category extends Connect{
        function index(){
           $data['main']='category/main';
           
           $this->load_views('admin/index',$data);
        }

    }
?>