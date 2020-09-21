<?php
    class Database{
        protected $servername = SV;
        protected $username = USR;
        protected $password = PAS;
        protected $dbname = DB;

        public $conn='';

        function __construct(){
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }

        function p_update($table, $array, $id)
        {
            // xét sql
            $str_sql='';

            foreach($array as $key => $value)
            {
                $str_sql .= $key .'=' . "'".$value."',";
            }

            $str_sql = trim($str_sql, ',');

            $sql = "UPDATE $table SET $str_sql WHERE ID=$id";

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

        function p_insert($table, $array)
        {
            // xét tên cột và giá trị cột
            $str_cot='';
            $str_value='';

            foreach($array as $key => $value)
            {
                $str_cot .= $key .',';
                $str_value .= "'".$value."',";
            }

            $str_cot = trim($str_cot, ',');
            $str_value = trim($str_value, ',');

            $sql = "INSERT INTO $table ($str_cot) VALUES ($str_value)";

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

        function p_delete($table, $id)
        {
            $sql = "DELETE FROM $table WHERE ID=$id";

            if($this->conn->query($sql) === TRUE)
            {
                $kq = "ok-delete";
            }
            else
            {
                $kq = "Error: " . $sql . "<br>" . $this->conn->error;
            }
            
            return $kq;
        }

        function p_select_row($table, $id)
        {
            //echo $id;die;
            $sql = "SELECT * FROM $table WHERE ID=$id";
            $result = $this->conn->query($sql);

            if($result->num_rows > 0)
            {
                $kq = $result->fetch_assoc();
            }
            else
            {
                $kq = '0 results';
            }

            return $kq;
        }
    }
?>