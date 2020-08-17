<?php
    class Layout extends Connect{
        // function __construct(){
        //     echo 'Đây là layout';
        // }
        function index(){
            
            $data['main'] = 'home/maincontent-area';
            
            if(isset($_GET['url']))
            {
                if( strpos($_GET['url'],'.html'))
                {
                    //echo 'Đây là trang sản phẩm';
                    $data['main'] = 'product/main';
                }
                else
                {
                    //echo 'Đây là trang danh mục';
                    $data['main'] = 'category/main';
                }
               
            }
            $this->load_views('layout/index',$data);
        }
    }
?>