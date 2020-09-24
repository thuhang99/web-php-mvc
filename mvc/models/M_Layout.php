<?php
    class M_Layout extends Database{
        
        function last_orders()
        {
            $sql = "SELECT ID FROM orders ORDER BY ID DESC";
            $result = $this->conn->query($sql);
            
            $row = $result->fetch_assoc();

            return $row['ID'];
        }

        function customer_exist($phone)
        {
            $sql = "SELECT ID FROM customer WHERE phone=$phone";
            $result = $this->conn->query($sql);
            
            $row = $result->fetch_assoc();

            return $row['ID'];
        }

        function last_customer()
        {
            $sql = "SELECT ID FROM customer ORDER BY ID DESC";
            $result = $this->conn->query($sql);
            
            $row = $result->fetch_assoc();

            return $row['ID'];
        }

        function insert($table, $array)
        {
            return $this->p_insert($table, $array);
        }

        function check_customer($phone)
        {
            $sql = "SELECT * FROM customer WHERE phone=$phone";
            $result = $this->conn->query($sql);
            
            return $result->num_rows;
        }

        function area($table, $status, $name_where, $value_where)
        {
            if($status==1)
            {
                $sql = "SELECT * FROM $table";
            }
            else
            {
                $sql = "SELECT * FROM $table WHERE $name_where=$value_where";
            }
            
            $result = $this->conn->query($sql);

            $str='<option value="0">Chọn…</option>';

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $str.='<option value="'.$row['ID'].'">'.$row['name'].'</option>';
                }
            }

            return $str;
        }

        function pull_rows_product($id)
        {
            $sql = "SELECT * FROM product WHERE ID=$id";
            $result = $this->conn->query($sql);

            return $result->fetch_assoc();
        }

        function pull_results_product($id_category)
        {
            $sql = "SELECT * FROM product WHERE id_category=$id_category ORDER BY ID DESC";
            $result = $this->conn->query($sql);

            $str='';

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $str .= '<div class="col-md-3 col-sm-6">
                        <div class="single-shop-product">
                            <div class="product-upper">
                                <img src="'.URL.'uploads/products/'.$row['img'].'" alt="'.$row['name'].'" class="img1">
                            </div>
                            <h2><a href="'.URL.$row['link'].'.html">'.$row['name'].'</a></h2>
                            <div class="product-carousel-price">
                                <ins>'.number_format($row['price']).' VNĐ</ins>
                            </div>  
                            
                            <div class="product-option-shop">
                                <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>
                            </div>                       
                        </div>
                    </div>';
                }
            }

            return $str;
        }

        function pull_rows_category($link){
            $sql = "SELECT * FROM category WHERE link='$link'";
            $result = $this->conn->query($sql);
            return $result->fetch_assoc();
        }

        function category_cha(){
            $sql = "SELECT * FROM category WHERE id_cha=0";
            $result = $this->conn->query($sql);

            $str='';

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $str .= '<li>';
                    $str .= '<a href="'.URL.$row['link'].'">'.$row['name'].'</a>';
                    $str .= '</li>';
                }
            }

            return $str;
        }
        function latest_product(){
            $sql = "SELECT * FROM product ORDER BY ID DESC LIMIT 0, 10";
            $result = $this->conn->query($sql);

            $str='';

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $str .= '<div class="single-product">
                        <div class="product-f-image">
                            <img src="'.URL.'uploads/products/'.$row['img'].'" alt="" class="img1">
                            <div class="product-hover">
                                <a href="javascript:;" class="add-to-cart-link" onclick="add_to_cart('.$row['ID'].')"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                <a href="'.URL.$row['link'].'.html" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                            </div>
                        </div>
                        
                        <h2><a href="'.URL.$row['link'].'.html" onclick="update_views()">'.$row['name'].'</a></h2>
                        
                        <div class="product-carousel-price">
                            <ins>'.number_format($row['price']).' VNĐ</ins>
                        </div> 
                    </div>';
                }
            }

            return $str;
        }
    }
?>