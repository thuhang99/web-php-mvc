<?php
    class M_Product extends Database{
        function select_table(){
            $sql = 'SELECT * FROM product ORDER BY id DESC LIMIT 0,5';
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row

                $str='
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
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

                    $str .= '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['link'].'</td>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>
                            <a href=""><i class="fas fa-edit"></i> Sửa</a>
                            <a href="#" class="text-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
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