<?php

    class db{
        public $hostname;
        public $username;
        public $password;
        public $db_name;


        public function __construct($hostname, $username, $password, $db_name) {
            $this->hostname = $hostname;
            $this->username = $username;
            $this->password = $password;
            $this->db_name = $db_name;

            $conn = mysqli_connect($this->hostname,$this->username, $this->password, $this->db_name);

            if(!$conn) {
                echo mysqli_error($conn());
            }else{
                echo "Database Connected";
            }

        }

    }

    $database = new db("localhost", "root", "", "learning");

?>