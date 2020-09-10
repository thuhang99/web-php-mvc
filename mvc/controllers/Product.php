<?php
    class Product extends Connect{
        function index(){

            $db = $this->load_models('M_Product');

            //Phân trang
            //Tìm tổng số dòng
            $sum_rows = $db -> sum_rows('product');
            
            $limit = 5;

            $page = 0;

            if(isset($_GET['page']))
            {
               $page = $_GET['page'];
            }

            if($page == 0 || $page == 1)
            {
                $start = 0;
            }
            else {
                $start = ($page - 1) * $limit;
            }

            //hiển thị phân trang
            $value_pagination = ceil($sum_rows/$limit);
            //Disable đầu
            $disabled_first = '';
            if($page == 0 || $page == 1)
            {
                $disabled_first = 'disabled';
            }

            //Trang đầu
            $link_first = URL.'Product?page=1';
            $view_pagination = '<li class="page-item '.$disabled_first.' "><a class="page-link" href="'.$link_first.'">First</a></li>';
            //Trang tiếp
            $link_first_one =  URL.'Product/?page='.($page - 1);
            $view_pagination .= '<li class="page-item '.$disabled_first.' "><a class="page-link" href="'.$link_first_one.'"><<</a></li>';

           
            if($page == 0)
            {
                $page = 1;
            }
            for($i = 1; $i <= $value_pagination; $i++)
            {
                $link_pagination = URL.'Product?page='.$i;
                $active = '';
                if($i == $page)
                {
                    $active = 'active';
                }
                $view_pagination .= '<li class="page-item '.$active.'"><a class="page-link" href="'.$link_pagination.'">'.$i.'</a></li>';
            }

            //Disable cuối
            $disabled_last = '';
            if($page == $value_pagination)
            {
                $disabled_last = 'disabled';
            }
            //Trang cuối
            $view_pagination .= '<li class="page-item '.$disabled_last.' "><a class="page-link" href="'.$link_last_one.'">>></a></li>';

            $link_last_one =  URL.'Product/?page='.($page + 1);
            $view_pagination .= '<li class="page-item '.$disabled_last.' "><a class="page-link" href="#">Last</a></li>';

            $data['pagination'] = $view_pagination;
            // Load models
           
            $data['table'] = $db->select_table($start, $limit);

            // lấy ra giá trị search
            if( isset($_GET['search']) )
            {
                $search = $_GET['search'];
                $data['table'] = $db->search_table($search);
            }
                  
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
            $name=$link=$content=$img=$err=$status='';
            // Lấy dữ liệu
            $name=$_POST['name'];
            $link=$_POST['link'];
            $content=$_POST['content'];
            $status=$_POST['status'];
            
            $flag=1;

            //echo $name .'/'. $link .'/'. $content .'/'. $status;
            //Kiểm tra dữ liệu
            
            // Kiểm tra Tên sản phẩm
            if(strlen($name)>100){
                $flag=0;
                $err.="Tên sản phẩm vượt quá số kí tự cho phép\n";
            }

            // Kiểm tra link
            if(strlen($link)>100){
                $flag=0;
                $err.="Link vượt quá số kí tự cho phép\n";
            }

            // kiểm tra ảnh
            if( $_FILES['img']['name']!='' )
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
                    //echo 'Upload File thành công';
                    $img = $_FILES['img']['name'];
                }
                else
                {
                    $err.="Ảnh chưa được tải lên\n".$err_uploads;
                    $flag=0;
                }
            }

            // KẾT QUẢ
            if($flag==1){
                // Lấy dữ liệu
                $db = $this->load_models('M_Product');
                $kq = $db->insert($name, $link, $img, $content, $status);

                echo $kq;

            }else{
                echo $err;
            }
        }
        function edit($id){

            // Lấy dữ liệu
            $db = $this->load_models('M_Product');
            $row = $db->select_row($id);

            // gửi dữ liệu qua view
            $data['row'] = $row;

            // load giao diện trang edit product/edit.php
            $data['main'] = 'product/edit';

            // Chỉ truyền $data qua class Connect, function load_views
            $this->load_views('admin/index', $data);
        }
        function process_edit(){

            // Lấy id
            $id = $_POST['id'];

            // khai báo
            $name=$link=$content=$img=$err=$status='';
            // Lấy dữ liệu
            $name=$_POST['name'];
            $link=$_POST['link'];
            $content=$_POST['content'];
            $status=$_POST['status'];
            
            $flag=1;

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

            // Lấy lại dữ liệu từ id đã có ở trên
            $db = $this->load_models('M_Product');
            $row = $db->select_row($id);

            // khi người ta không chọn tấm ảnh nào
            $img = $row['img'];

            // kiểm tra ảnh
            if( $_FILES['img']['name']!='' )
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
                    //echo 'Upload File thành công';
                    $img = $_FILES['img']['name'];
                }
                else
                {
                    $err.="Ảnh chưa được tải lên\n".$err_uploads;
                    $flag=0;
                }
            }

            // KẾT QUẢ
            if($flag==1){
                // Lấy dữ liệu
                $db = $this->load_models('M_Product');
                $kq = $db->update($name, $link, $img, $content, $status, $id);

                echo $kq;

            }else{
                echo $err;
            }
        }

        function delete()
        {
            $id = $_POST['id'];

            // Kết nối database
            $db = $this->load_models('M_Product');

            // hàm lấy ra thông tin sản phẩm
            $select = $db->select_row($id);

            // lấy ra tên tấm ảnh
            $name_img = $select['img'];
            
            if($name_img!='')
            {
                $target_dir = 'uploads/products/';
                $target_file = $target_dir . basename( $name_img );

                if( file_exists($target_file) )
                {
                    // xóa ảnh trong folder
                    unlink($target_file);
                }
            }

            // xóa dữ liệu
            $kq = $db->delete($id);

            echo $kq;
        }
    }
?>