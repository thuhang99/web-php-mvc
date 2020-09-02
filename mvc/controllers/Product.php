<?php
    class Product extends Connect{
        function index(){

            //Load models
            $select = $this->load_models('M_Product');
            $data['table'] = $select->select_table();

            // load giao diện trang sản phẩm product/main.php
            $data['main'] = 'product/main';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
        function add(){
            // load giao diện trang add product/add.php
            $data['main'] = 'product/add';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
        function process_add(){
            // khai báo
            $name=$link=$content=$img=$err='';
            // Lấy dữ liệu
            $name=$_POST['name'];
            $link=$_POST['link'];
            $content=$_POST['content'];
            $status=$_POST['status'];

            $status=$flag=1;
            if($status!='on'){ $status=0; }

            //echo $name .'/'. $link .'/'. $content .'/'. $status;
            //Kiểm tra dữ liệu
            
            // Kiểm tra Tên sản phẩm
            if(strlen($name)>70){
                $flag=0;
                $err.="Tên sản phẩm vượt quá số kí tự cho phép\n";
            }

            // Kiểm tra link
            if(strlen($link)>70){
                $flag=0;
                $err.="Link vượt quá số kí tự cho phép\n";
            }

            // kiểm tra ảnh
            if( $_FILES['img']['name'] != '' )
            {
                $target_dir = 'uploads/products/';
                $target_file = $target_dir . basename( $_FILES['img']['name'] );

                // Phương pháp gắn cờ
                $flag_uploads=1;

                // thông báo lỗi
                $err_uploads = '';

                // 1 kiểm tra có tồn tại hay chưa

                if( file_exists($target_file) )
                {
                    $flag_uploads=0;
                    $err_uploads = "File đã tồn tại\n";
                }

                // 2 kiểm tra file có đúng định dạng hay chưa

                $pattern = '/^(image\/jpeg)|(image\/png)$/';
                $subject = $_FILES['img']['type'];

                if( preg_match( $pattern, $subject ) == FALSE )
                {
                    $flag_uploads=0;
                    $err_uploads = "File không đúng định dạng: .jpg, .png\n";
                }

                // 3 kiểm tra file có đúng kích thước hay chưa

                if( $_FILES['img']['size'] > 102400 ) // 100 KB
                {
                    $flag_uploads=0;
                    $err_uploads = "File vượt quá dung lượng: 100KB\n";
                }

                // trải qua 3 bước kiểm tra sẽ úp file lên server

                if( $flag_uploads==1 )
                {
                    move_uploaded_file( $_FILES['img']['tmp_name'], $target_file );
                    echo 'Upload File thành công';
                }
                else
                {
                    $err.="Ảnh chưa được tải lên\n".$err_uploads;
                    $flag=0;
                }
            }

            // KẾT QUẢ
            if($flag==1){
                // Kết nối database và lưu dữ liệu
                $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname = 'db_shop';

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = 'INSERT INTO product (name, link, content, status) VALUES ("'.$name.'", "'.$link.'","'.$content.'","'.$status.'" )';
            //$result = $conn->query($sql);
            if($conn->query($sql) == TRUE)
            {
                echo "ok";
            }
            else {
                echo "Error: ".$sql."<br>". $conn->error;
            }
            $conn->close();
            }else{
                echo $err;
            } 
            
        }
        function edit($id){
            // load giao diện trang edit product/edit.php
            $data['main'] = 'product/edit';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
    }
?>