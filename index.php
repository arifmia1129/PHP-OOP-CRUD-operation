<?php

class db
{
    public $hostname;
    public $username;
    public $password;
    public $db_name;

    public $conn;



    // connect to db
    public function __construct($hostname, $username, $password, $db_name)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;

        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->db_name);

        if (!$this->conn) {
            echo "Failed to connect db\n";
        } else {
            echo "Database Connected\n";
        }
    }


    // insert data to table

    public function insert_info($name, $gender, $class, $roll)
    {
        $stmt = $this->conn->prepare("INSERT INTO student(name, gender, class, roll) VALUES(?, ?, ?, ?)");

        $stmt->bind_param("ssss", $name, $gender, $class, $roll);

        if($stmt->execute()) {
            echo "Data inserted to table successfully\n";
        }else{
            echo "Failed to inserted data to table.";
        }

        $stmt->close();
    }


    public function update_info($where, $field, $data) {

        $allowed_field = ["name", "gender", "class", "roll"];

        if(!in_array($field, $allowed_field)){
            echo "Invalid field\n";
            return;
        }

        $stmt = $this->conn->prepare("UPDATE student SET $field = ? where name = ?");
        $stmt -> bind_param("ss",  $data, $where);

        if($stmt->execute()) {
            echo "Data updated successfully\n";
        }else{
            echo "Failed to updated data";
        }
    }
}

$database = new db("localhost", "root", "", "oop");

// $database->insert_info("Binu", "female", "Honours", "12345");

$database->update_info("Binu", "class", "HSC");

?>
