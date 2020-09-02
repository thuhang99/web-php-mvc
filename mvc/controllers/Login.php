<?php
    class Login extends Connect{
        function index(){          
            $this->load_views('admin/login/index');
        }
        function process()
        {
            $username = $password = '';
            //lấy dữ liệu
            $username = $_POST['username'];
            $password = $_POST['password'];

            echo $username.'/'.$password;

            //kiểm tra
            $flag = 1;
            $err = '';

            if($username == '')
            {
                $flag = 0;
                $err.='Tên đăng nhập rỗng';
            }
            if($password == '')
            {
                $flag = 0;
                $err.='Mật khẩu rỗng';
            }

            //kết quả
            if($flag == 1)
            {
                //database
            }
            else {
                echo $err;
            }
        }
    }
?>