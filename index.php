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
            echo "Failed to connect db ";
        } else {
            // echo "Database Connected ";
        }
    }


    // insert data to table

    public function insert_info($name, $gender, $class, $roll)
    {
        $stmt = $this->conn->prepare("INSERT INTO student(name, gender, class, roll) VALUES(?, ?, ?, ?)");

        $stmt->bind_param("ssss", $name, $gender, $class, $roll);

        if($stmt->execute()) {
            echo "Data inserted to table successfully ";
        }else{
            echo "Failed to inserted data to table.";
        }

        $stmt->close();
    }

// update data to table
    public function update_info($where, $field, $data) {

        $allowed_field = ["name", "gender", "class", "roll"];

        if(!in_array($field, $allowed_field)){
            echo "Invalid field ";
            return;
        }

        $stmt = $this->conn->prepare("UPDATE student SET $field = ? where name = ?");
        $stmt -> bind_param("ss",  $data, $where);

        if($stmt->execute()) {
            echo "Data updated successfully ";
        }else{
            echo "Failed to updated data";
        }
    }


    // get/select data from table

    public function get_data() {
        $stmt = $this->conn->prepare("SELECT * FROM student");

        if($stmt->execute()) {

            $result = $stmt->get_result();
            


           while($row = mysqli_fetch_array($result)) {
                $name = $row["name"];
                $gender = $row["gender"];
                $class = $row["class"];
                $roll = $row["roll"];

                echo "Name: $name. Gender: $gender. Class: $class Roll: $roll";
                echo "<br>";
           }
        }else{
            echo "Failed to fetch data";
        }
    }

    // delete data

    public function delete_data($t_name, $c_name, $c_value) {
        $stmt = $this->conn->prepare("DELETE FROM $t_name WHERE $c_name = ?");

        $stmt->bind_param("s", $c_value);

        if($stmt->execute()) {
            echo "Data deleted successfully";
        }else{
            echo "Failed to delete data";
        }
    }
}

$database = new db("localhost", "root", "", "oop");

// $database->insert_info("Binu", "female", "Honours", "12345");

// $database->update_info("Binu", "class", "HSC");

// $database->get_data();

$database->delete_data("student", "name", "Arif");

?>
