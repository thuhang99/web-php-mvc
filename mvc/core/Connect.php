<?php
    class Connect
    {
        function load_views($name, $data=[])
        {
            require_once './mvc/views/'.$name.'.php';
        }
    }
?>