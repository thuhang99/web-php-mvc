<?php
    class Product extends Connect{
        function index(){
           $data['main']='product/main';
           
           $this->load_views('admin/index',$data);
        }

    }
?>