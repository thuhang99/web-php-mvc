<?php
    class M_Product extends Database{
        function sum_rows($table)
        {
            $sql = "SELECT COUNT(*) AS total FROM $table";
            $result = $this -> conn -> query($sql);

            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $kq = $row['total'];
            }
            else {
                $kq = 0;
            }
            return $kq;

        }
        function search_table($search)
        {
            
            $sql = "SELECT * FROM product WHERE name LIKE '%".$search."%'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row

                $str='
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Hình ảnh</th>
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
                    <tr id="del_'.$row['id'].'">
                        <td>'.$i.'</td>
                        <td><img src="'.URL.'uploads/products/'.$row['img'].'" width="50"></td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['link'].'</td>
                        <td>
                            <input type="checkbox"'.$checked.'>
                        </td>
                        <td>
                            <a href="'.URL.'Product/edit/'.$row['id'].'"><i class="fas fa-edit">
                            
                            </i> Sửa</a>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#modal-danger'.$row['id'].'">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    </td>
                </tr>

                <div class="modal fade" id="modal-danger'.$row['id'].'">
                    <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                        <div class="modal-header">
                        <h4 class="modal-title">Thông báo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa <b>'.$row['name'].'</b>??</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="xoa_ngay('.$row['id'].')">Xóa ngay</button>
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
        function delete($id)
        {
            $sql = "DELETE FROM product WHERE id = $id";
            if($this->conn->query($sql) == TRUE)
            {
                $kq = "ok-delete";
            }
            else
            {
                $kq = "Error: ".$sql."<br>".$this->conn->error;    
            }
            return $kq;
        }

        function update($name, $link, $content, $img, $status, $id)
        {
            $sql = "UPDATE product SET name='".$name."', link='".$link."', 
            content='".$content."', img='".$img."', status='".$status."'
             WHERE id=$id";

            if($this->conn->query($sql) === TRUE)
            {
                $kq = "ok-update";
            }
            else
            {
                $kq = "Error: " . $sql . "<br>" . $this->conn->error;
            }
            
            return $kq;
        }

        function insert($name, $link, $img, $content, $status)
        { 
                $sql = 'INSERT INTO product (name, link, img, content, status)
                VALUES ("'.$name.'", "'.$link.'", "'.$img.'", "'.$content.'", "'.$status.'")';
    
                if($this->conn->query($sql) === TRUE)
                {
                    $kq = "ok";
                }
                else
                {
                    $kq = "Error: " . $sql . "<br>" . $this->conn->error;
                }
                
                return $kq;
        }
        function select_row($id)
        {
            $sql = "SELECT * FROM product WHERE id = $id";
            $result = $this->conn->query($sql);
            
            if ($result->num_rows > 0) 
            {
                $kq = $result->fetch_assoc();
                
            }
            else {
                $kq = 'No result';
            }
            return $kq;

        }
        function select_table($start, $limit){
            $sql = "SELECT * FROM product ORDER BY id DESC LIMIT $start,$limit";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row

                $str='
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Hình ảnh</th>
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
                    <tr id="del_'.$row['id'].'">
                        <td>'.$i.'</td>
                        <td><img src="'.URL.'uploads/products/'.$row['img'].'" width="50"></td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['link'].'</td>
                        <td>
                            <input type="checkbox"'.$checked.'>
                        </td>
                        <td>
                            <a href="'.URL.'Product/edit/'.$row['id'].'"><i class="fas fa-edit">
                            
                            </i> Sửa</a>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#modal-danger'.$row['id'].'">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    </td>
                </tr>

                <div class="modal fade" id="modal-danger'.$row['id'].'">
                    <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                        <div class="modal-header">
                        <h4 class="modal-title">Thông báo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa <b>'.$row['name'].'</b>??</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="xoa_ngay('.$row['id'].')">Xóa ngay</button>
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