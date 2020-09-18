<?php
    class Layout extends Connect{
        function index(){
            // Load models
            $db = $this->load_models('M_Layout');

            // load giao diện trang chủ home/main.php
            $data['main'] = 'home/maincontent_area';

            if( isset($_GET['url']) )
            {
                // strpos : kiểm tra .html có hay không
                if( strpos($_GET['url'], '.html') )
                {
                    // cập nhật views

                    //echo 'Đây là trang sản phẩm';
                    $data['main'] = 'product/main';

                    // giao diện giỏ hàng
                    if($_GET['url'] == 'gio-hang.html')
                    {
                        print_r($_SESSION['cart']);
                        die;
                        
                        $data['main'] = 'cart/main';
                    }
                }
                else
                {
                    // lấy dữ liệu bảng category dựa vào link
                    $link = $_GET['url'];
                    $row_category = $db->pull_rows_category($link);
                    $data['row_category'] = $row_category;

                    // lấy ra danh sách sản phẩm có chứa id_category
                    $product = $db->pull_results_product($row_category['ID']);
                    $data['product'] = $product;

                    //echo 'Đây là trang danh mục';
                    $data['main'] = 'category/main';
                }
            }

            // menu
            $data['menu'] = $this->menu();

            // latest product
            $data['latest_product'] = $db->latest_product();

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('layout/index', $data);
        }

        function menu()
        {
            $str = '<li class="active"><a href="'.URL.'">Trang chủ</a></li>';
            $str .= '<li><a href="'.URL.'gioi-thieu.html">Giới thiệu</a></li>';

            // Load models
            $db = $this->load_models('M_Layout');

            // danh mục sản phẩm
            $str .= $db->category_cha();

            $str .= '<li><a href="'.URL.'lien-he.html">Liên hệ</a></li>';

            return $str;
        }

        function add_to_cart()
        {
            // Load models
            $db = $this->load_models('M_Layout');

            // id sản phẩm lấy từ ajax
            $id = $_POST['ID'];

            // lấy ra thông tin sản phẩm
            $row_product = $db->pull_rows_product($id);

            $array = array(
                'name' => $row_product['name'],
                'link' => $row_product['link'],
                'price' => $row_product['price'],
                'qty' => 1
            );

            // thêm vào giỏ hàng
            $_SESSION['cart'][$id] = $array;

            //print_r($_SESSION['cart']);

        }
    }
?>