<?php

class Users
{
    public $connect;

    protected final function connect()
    {
        $this->connect = new mysqli("localhost", "root", "sanjeev98", "users");
        if ($this->connect->connect_error) {
            die("Connection failed: " . $this->connect->connect_error);
        }
    }

    protected final function insert1($firstname, $lastname, $mail, $phone_number, $gender, $department, $spoken_language, $speaking_language, $birthday, $address)
    {
        $sql = "INSERT INTO user(firstname,lastname,mail,phoneNumber,gender,department,language,birthday,language1,address)VALUES ('$firstname','$lastname','$mail','$phone_number','$gender','$department','$spoken_language','$birthday','$speaking_language','$address')";
        if (!($this->connect->query($sql) === TRUE)) {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    protected final function insert2($phoneNumber, $media, $hours, $percentage)
    {
        $sql = "INSERT INTO detail(phonenumber,media,hours,percentage)VALUES ('$phoneNumber','$media',$hours,$percentage)";
        if (!($this->connect->query($sql) === TRUE)) {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    protected final function select1($value)
    {
        $sql = "SELECT * FROM user where phonenumber='$value'";
        $result = $this->connect->query($sql);
        return $result;
    }

    protected final function select2($value)
    {
        $sql = "SELECT * FROM detail where phonenumber='$value'";
        $result = $this->connect->query($sql);
        return $result;
    }

}

?>
