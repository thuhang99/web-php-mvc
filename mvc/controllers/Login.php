<?php
    class Login extends Connect{
        function index(){
            $this->load_views('admin/login/index');
        }
        function process(){
            // khai báo
            $username=$password='';
            // lấy dữ liệu
            $username = $_POST['username'];
            $password = $_POST['password'];
            // kiểm tra dữ liệu
            // echo $username.'/'.$password;

            $flag=1;
            $err='';

            // kiểm tra username
            if($username==''){
                $flag=0;
                $err.='Tên đăng nhập không được rỗng';
            }

            // kiểm tra password
            if($password==''){
                $flag=0;
                $err.='Mật khẩu không được rỗng';
            }

            // KẾT QUẢ
            if($flag==1){
                // Kết nối database và gắn session, chuyển trang vào admin
            }else{
                echo $err;
            }
        }
    }
?>