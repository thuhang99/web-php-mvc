<?php 
    class Database{
        protected $servername = SV;
        protected $username = USR;
        protected $password = PASS;
        protected $dbname = DB;

        public $conn;

        function __construct()
        {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if($this->conn->connect_error)
            {
                die("Connection failed: ". $this->conn->connect_error);
            }
        }
    }

?>