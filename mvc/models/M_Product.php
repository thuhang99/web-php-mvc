<?php
    class M_Product extends Database{

        private $table = 'product';

        // $id để phân biệt là add hay edit
        function list_category($id)
        {
            $sql = "SELECT * FROM category WHERE id_cha=0";
            $result = $this->conn->query($sql);

            if($result->num_rows > 0){
                $str='';

                while($row = $result->fetch_assoc()) {

                    // Xét selected cho trường là edit
                    if($row['ID'] == $id)
                    {
                        $selected = 'selected';
                    }
                    else
                    {
                        $selected = '';
                    }

                    $str .= '<option value="'.$row['ID'].'" '.$selected.'>';
                    $str .= $row['name'];
                    $str .= '</option>'; 

                    // lấy ra thằng con
                    $sql_child = "SELECT * FROM category WHERE id_cha=$row[ID]";
                    $result_child = $this->conn->query($sql_child);

                    if($result_child->num_rows > 0){
                        $str_child='';

                        while($row_child = $result_child->fetch_assoc()) {

                            // Xét selected cho trường là edit
                            if($row_child['ID'] == $id)
                            {
                                $selected_child = 'selected';
                            }
                            else
                            {
                                $selected_child = '';
                            }

                            $str_child .= '<option value="'.$row_child['ID'].'" '.$selected_child.'>';
                            $str_child .= '|----- '.$row_child['name'];
                            $str_child .= '</option>';
                        }

                        $str .= $str_child;
                    }
                    else
                    {
                        $str .= '';
                    }
                }

                $kq = $str;
            }
            else
            {
                $kq = '';
            }

            return $kq;
        }

        function sum_rows($table)
        {
            $sql = "SELECT COUNT(*) AS total FROM $table";
            $result = $this->conn->query($sql);

            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();

                $kq = $row['total'];
            }
            else
            {
                $kq = 0;
            }

            return $kq;
        }

        function search_table($search)
        {
            $sql = "SELECT * FROM product WHERE name LIKE '%".$search."%'";
            $result = $this->conn->query($sql);

            if($result->num_rows > 0){

                $str='
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Tên</th>
                            <th>Link</th>
                            <th>Hiển thị</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                
                $i=0;

                while($row = $result->fetch_assoc()) {
                    
                    $i++;

                    ($row['status']==1)?$checked='checked':$checked='';

                    $str .= '
                    <tr id="del_'.$row['ID'].'">
                        <td>'.$i.'</td>
                        <td><img src="'.URL.'uploads/products/'.$row['img'].'" width="50"></td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['link'].'</td>
                        <td>
                            <input type="checkbox" '.$checked.'>
                        </td>
                        <td>
                            <a href="'.URL.'Product/edit/'.$row['ID'].'">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#modal-danger'.$row['ID'].'">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="modal-danger'.$row['ID'].'">
                        <div class="modal-dialog">
                        <div class="modal-content bg-danger">
                            <div class="modal-header">
                            <h4 class="modal-title">Thông báo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa <b>'.$row['name'].'</b> ??</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Thoát</button>
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="xoa_ngay('.$row['ID'].')">Xóa ngay</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    ';

                }

                $str .= '
                    </tbody>
                </table>
                ';

                $kq=$str;

            }else{
                $kq = '0 results';
            }

            return $kq;
        }

        function delete($id)
        {
            return $this->p_delete($this->table, $id);
        }

        function update($array, $id)
        {
            return $this->p_update($this->table, $array, $id);
        }

        function insert($array)
        {
            return $this->p_insert($this->table, $array);
        }

        function select_row($id)
        {
            return $this->p_select_row($this->table, $id);
        }

        function select_table($start, $limit)
        {
            $sql = "SELECT * FROM product ORDER BY ID DESC LIMIT $start,$limit";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row

                $str='
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Tên</th>
                            <th>Giá tiền</th>
                            <th>Danh mục</th>
                            <th>Hiển thị</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                
                $i=0;

                while($row = $result->fetch_assoc()) {
                    
                    // Lấy ra danh mục
                    $sql_category = "SELECT * FROM category WHERE ID=$row[id_category]";
                    $result_category = $this->conn->query($sql_category);
                    $row_category = $result_category->fetch_assoc();

                    $i++;

                    ($row['status']==1)?$checked='checked':$checked='';

                    $str .= '
                    <tr id="del_'.$row['ID'].'">
                        <td>'.$i.'</td>
                        <td><img src="'.URL.'uploads/products/'.$row['img'].'" width="50"></td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['price'].'</td>
                        <td><a href="'.URL.$row_category['link'].'" target="_blank">
                            '.$row_category['name'].'</a></td>
                        <td>
                            <input type="checkbox" '.$checked.'>
                        </td>
                        <td>
                            <a href="'.URL.'Product/edit/'.$row['ID'].'">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#modal-danger'.$row['ID'].'">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="modal-danger'.$row['ID'].'">
                        <div class="modal-dialog">
                        <div class="modal-content bg-danger">
                            <div class="modal-header">
                            <h4 class="modal-title">Thông báo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa <b>'.$row['name'].'</b> ??</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Thoát</button>
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="xoa_ngay('.$row['ID'].')">Xóa ngay</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    ';

                }

                $str .= '
                    </tbody>
                </table>
                ';

                $kq=$str;

            } else {
                $kq="0 results";
            }

            return $kq;
        }
    }
?>