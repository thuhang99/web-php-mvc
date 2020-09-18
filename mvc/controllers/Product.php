<?php
    class Product extends Connect{
        function index(){

            // Load models
            $db = $this->load_models('M_Product');

            // Phân trang
            
            // --- 1. Tìm tổng số dòng
            $sum_rows = $db->sum_rows('product');
            // --- 2. Số dòng trên 1 trang
            $limit = 5;
            // --- 3. Số trang
            $page = 0;
            
            if( isset($_GET['page']) )
            {
                $page = $_GET['page'];
            }

            // --- 4. Giá trị bắt đầu
            if( $page==0 || $page==1 )
            {
                $start=0;
            }
            else
            {
                // page=2 => $start=5
                // page=3 => $start=10
                // page=4 => $start=15

                $start = ($page-1) * $limit;
            }

            // views hiển thị phân trang

            $value_pagination = ceil( $sum_rows / $limit );

            // kiểm tra disabled đầu
            $disabled_dau='';

            if( $page==0 || $page==1 )
            {
                $disabled_dau='disabled';
            }

            // link first
            $link_first = URL.'Product?page=1';

            $views_pagination = '<li class="page-item '.$disabled_dau.'">
            <a class="page-link" href="'.$link_first.'">First</a></li>';

            // link prev
            $link_prev = URL.'Product?page='.($page-1);

            $views_pagination .= '<li class="page-item '.$disabled_dau.'">
            <a class="page-link" href="'.$link_prev.'">Prev</a></li>';

                // chuyển page=0 về page=1 để active khi
                // không có phân trang
                if($page==0)
                {
                    $page=1;
                }

                // Xét hiển thị phân trang

                if( $page > $value_pagination )
                {
                    header('Location:' .URL.'Product' );
                }

                $min = $page;

                if( $page > $value_pagination - 5 )
                {
                    $max = $page + ($value_pagination - $page);
                }
                else
                {
                    $max = $page + 5;
                }

                // end

                for ($i=$min; $i <= $max; $i++)
                {
                    $link_pagination = URL.'Product?page='.$i;

                    // kiểm tra link active
                    $active = '';

                    if($i==$page)
                    {
                        $active = 'active';
                    }

                    $views_pagination .= '<li class="page-item '.$active.'">
                    <a class="page-link" href="'.$link_pagination.'">
                    '.$i.'</a></li>';
                }

            // kiểm tra disabled cuối
            $disabled_cuoi='';

            if( $page==$value_pagination )
            {
                $disabled_cuoi='disabled';
            }

            // link next
            $link_next = URL.'Product?page='.($page+1);

            $views_pagination .= '<li class="page-item '.$disabled_cuoi.'">
            <a class="page-link" href="'.$link_next.'">Next</a></li>';

            // link last
            $link_last = URL.'Product?page='.$value_pagination;

            $views_pagination .= '<li class="page-item '.$disabled_cuoi.'">
            <a class="page-link" href="'.$link_last.'">Last</a></li>';

            $data['pagination'] = $views_pagination;

            // kết thúc

            $data['table'] = $db->select_table($start, $limit);

            // về nhà làm phần phân trang tìm kiếm

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

            // Load models
            $db = $this->load_models('M_Product');

            // lấy ra danh mục
            $data['category'] = $db->list_category(0);

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

            // danh mục
            $id_category=$_POST['id_category'];
            
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

                $array = [
                    'name' => $name,
                    'link' => $link,
                    'img' => $img,
                    'content' => $content,
                    'status' => $status,
                    'id_category' => $id_category
                ];

                $kq = $db->insert($array);

                echo $kq;

            }else{
                echo $err;
            }
        }
        function edit($id){

            // Lấy dữ liệu
            $db = $this->load_models('M_Product');
            $row = $db->select_row($id);

            // lấy ra danh mục
            $data['category'] = $db->list_category($row['id_category']);

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

            // danh mục
            $id_category=$_POST['id_category'];
            
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

                $array = [
                    'name' => $name,
                    'link' => $link,
                    'img' => $img,
                    'content' => $content,
                    'status' => $status,
                    'id_category' => $id_category
                ];

                $kq = $db->update($array, $id);

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