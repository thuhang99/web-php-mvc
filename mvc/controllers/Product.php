<?php
    class Product extends Connect{
        function index(){
           $data['main']='product/main';
           
           $this->load_views('admin/index',$data);
        }
        function add(){
            $data['main'] = 'product/add';
            
            $this->load_views('admin/index',$data);
        }

        function process_add()
        {
            echo 'Xin chào';
        }
        function edit($id){
            $data['main'] = 'product/edit';
            
            $this->load_views('admin/index',$data);
        }
    }
?>