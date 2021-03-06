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
                        $data['cart'] = [];

                        if( isset($_SESSION['cart']) )
                        {
                            //print_r($_SESSION['cart']);
                            $data['cart'] = $this->cart($_SESSION['cart']);
                        }
                        
                        $data['main'] = 'cart/main';
                    }

                    // giao diện thanh toán
                    if($_GET['url'] == 'thanh-toan.html')
                    {
                        // lấy ra danh sách tỉnh
                        $data['provine'] = $db->area('province', 1, '', '');

                        $data['main'] = 'cart/payment';
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

        function thanhtoan()
        {
            // thông tin khách hàng
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $province = $_POST['province'];
            $dictrict = $_POST['dictrict'];
            $wards = $_POST['wards'];

            // Load models
            $db = $this->load_models('M_Layout');

            // kiểm tra khách hàng có tồn tại chưa
            // phone

            $kq_phone = $db->check_customer($phone);

            if($kq_phone==0)
            {
                // thêm khách hàng vào database

                // coi chừng để sai tên cột

                $array=array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'id_province' => $province,
                    'id_dictrict' => $dictrict,
                    'id_ward' => $wards
                );

                $db->insert('customer', $array);

                // id_customer
                $id_customer = $db->last_customer();
            }
            else
            {
                // khách hàng đã có rồi
                // id_customer
                $id_customer = $db->customer_exist($phone);
            }

            // phương thức giao hàng
            $id_delivery = $_POST['id_delivery'];

            // cộng tiền hàng
            $congtienhang=0;
            foreach($_SESSION['cart'] as $key => $value){
                $congtienhang+=$value['qty']*$value['price'];
            }

            $array_order=array(
                'id_customer' => $id_customer,
                'id_delivery' => $id_delivery,
                'congtienhang' => $congtienhang
            );

            // thêm dữ liệu vào bảng đơn hàng (orders)
            $db->insert('orders', $array_order);

            // id_order
            $id_order = $db->last_orders();

            // thêm dữ liệu vào bảng chi tiết đơn hàng (order_details)
            foreach($_SESSION['cart'] as $key => $value){
                $array_order_details=array(
                    'id_order' => $id_order,
                    'name' => $value['name'],
                    'qty' => $value['qty'],
                    'price' => $value['price']
                );

                $db->insert('order_details', $array_order_details);
            }

            // tự động chuyển trang
            //header('location:'.URL);

            // Gửi mail
            include "class.phpmailer.php";
            include "class.smtp.php";

            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->Host = "smtp.gmail.com"; // specify main and backup server
            $mail->Port = 465; // set the port to use
            $mail->SMTPAuth = true; // turn on SMTP authentication
            $mail->SMTPSecure = 'ssl';
            $mail->Username = "me@gmail.com"; // your SMTP username or your gmail username
            $mail->Password = "pass"; // your SMTP password or your gmail password
            $from = "me@gmail.com"; // Reply to this email
            $to = "friend@gmail.com"; // Recipients email ID
            $name = "hello"; // Recipient's name
            $mail->From = $from;
            $mail->FromName = "hello"; // Name to indicate where the email came from when the recepient received
            $mail->AddAddress($to,$name);
            $mail->AddReplyTo($from,"Test thử");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // send as HTML
            $mail->Subject = "PHP mailler";
            $mail->Body = "<h1>Thông tin khách hàng</h1> '.$name.' <br> '.$email.' <br> '.$phone.' <br> '.$address.'"; //HTML Body
            //$mail->AltBody = "Mail nay duoc gui bang SMTP Gmail dung phpmailer class. - www.pavietnam.vn"; //Text Body
            //$mail->SMTPDebug = 2;
            if(!$mail->Send())
            {
                echo "<h1>Loi khi goi mail: " . $mail->ErrorInfo . '</h1>';
            }
            else
            {
                echo "<h1>Send mail thanh cong</h1>";
            }

            // hủy giỏ hàng
            //session_destroy();

            //echo 'ok';
        }

        function area()
        {
            $table = $_POST['table'];
            $status = $_POST['status'];
            $name_where = $_POST['name_where'];
            $value_where = $_POST['value_where'];

            // Load models
            $db = $this->load_models('M_Layout');

            // lấy ra dữ liệu area
            $kq = $db->area($table, $status, $name_where, $value_where);
            
            echo $kq;

            // test
            //echo $table.'/'.$status.'/'.$name_where.'/'.$value_where;
        }

        function delete_cart()
        {
            $id=$_POST['id'];
            // loại bỏ key ra khỏi mảng
            unset($_SESSION['cart'][$id]);
        }

        function updated_cart()
        {
            $k = $_POST['k'];

            $k = explode('/', $k);

            foreach ($k as $key => $value) {
                $v = explode(',', $value);

                // cập nhật giỏ hàng
                $_SESSION['cart'][$v[0]]['qty'] = $v[1];
            }
        }

        function cart($arr)
        {
            $str='';

            foreach ($arr as $key => $value) {
                $str.='<tr class="cart_item" id="tr_'.$key.'">
                    <td class="product-remove">
                        <a title="Remove this item" onclick="delete_cart('.$key.')" class="remove" href="javascript:;">×</a> 
                    </td>

                    <td class="product-thumbnail">
                        <a href="'.URL.$value['link'].'.html">
                            <img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="assets/layout/img/product-thumb-2.jpg">
                        </a>
                    </td>

                    <td class="product-name">
                        <a href="'.URL.$value['link'].'.html">'.$value['name'].'</a> 
                    </td>

                    <td class="product-price">
                        <span class="amount">£15.00</span> 
                    </td>

                    <td class="product-quantity">
                        <div class="quantity buttons_added">
                            <input type="button" class="minus" value="-">
                            <input type="number" size="4" name="qty" class="input-text qty text" title="Qty" value="'.$value['qty'].'" min="0" step="1">
                            <input type="hidden" name="_id" value="'.$key.'">
                            <input type="button" class="plus" value="+">
                        </div>
                    </td>

                    <td class="product-subtotal">
                        <span class="amount">£15.00</span> 
                    </td>
                </tr>';
            }

            return $str;
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
            $id = $_POST['id'];

            // lấy ra thông tin sản phẩm
            $row_product = $db->pull_rows_product($id);

            if( isset($_SESSION['cart'][$id]) )
            {
                if( $_SESSION['cart'][$id] )
                {
                    $qty = $_SESSION['cart'][$id]['qty']++;
                }
            }
            else
            {
                $array = array(
                    'name' => $row_product['name'],
                    'link' => $row_product['link'],
                    'price' => $row_product['price'],
                    'qty' => 1
                );

                // thêm vào giỏ hàng
                $_SESSION['cart'][$id] = $array;
            }
        }
    }
?>