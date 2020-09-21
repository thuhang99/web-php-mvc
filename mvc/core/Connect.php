<?php
    class Connect{
        function load_views($name, $data=[]){
            require_once './mvc/views/'.$name.'.php';
        }
        function load_models($name){
            require_once './mvc/models/'.$name.'.php';
            return new $name;
        }
    }
?>