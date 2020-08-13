<?php
    class App{
        // controllers(class)/action(function)/params(tham số function)

        protected $controllers = 'Layout'; // string, giá trị mặc định
        protected $actions = 'index'; // string, giá trị mặc định
        protected $params = []; // array, giá trị mặc định

        function __construct()
        {
            $url = $this->getUrl(); // Gọi function getUrl() để sử dụng

            // Lấy ra controllers $url[0]
            // echo $url[0];

            // Kiểm tra $url[0] có tồn tại hay không
            if( isset($url[0]) )
            {
                // Kiểm tra file (kiểm tra controllers) có tồn tại hay không
                if( file_exists( './mvc/controllers/'.$url[0].'.php' ) )
                {
                    // Tồn tại controllers thì gắn controllers mới là $url[0]
                    $this->controllers = $url[0];

                    // Loại bỏ phần tử đầu tiên
                    unset($url[0]);
                }
            }

            // Muốn lấy class của controllers ra sử dụng
            require_once './mvc/controllers/'.$this->controllers.'.php';

            // Gắn tên class = đối tượng
            $this->controllers = new $this->controllers;
            // echo $this->controllers;

            // Lấy ra actions $url[1]
            if( isset($url[1]) )
            {
                // Kiểm tra function có tồn tại trong class đã kiểm tra ở trên hay không
                if( method_exists($this->controllers, $url[1]) )
                {
                    // Tồn tại actions thì gắn actions mới là $url[1]
                    $this->actions = $url[1];

                    // Loại bỏ phần tử thứ 2
                    unset($url[1]);
                }
            }
            // kiểm tra fuction lấy ra được chưa
            // echo $this->actions;

            // Lấy ra params là những cái còn lại đằng sau actions
            if( is_array($url) )
            {
                $this->params = array_values($url);
            }

            // kiểm tra params
            // print_r( $this->params );

            // CHÚ Ý (QUAN TRỌNG): KẾT NỐI CONTROLLERS - ACTIONS - PARAMS LẠI VỚI NHAU,
            // SỬ DỤNG HÀM BÊN DƯỚI
            call_user_func_array( [$this->controllers, $this->actions], $this->params );
        }

        function getUrl()
        {
            // trim: loại bỏ khoảng trắng
            // explode: tách chuỗi thành mảng
            (isset($_GET['url'])) ? $kq = explode('/', trim($_GET['url']) ) : $kq = '';
            return $kq;
        }
    }
?>