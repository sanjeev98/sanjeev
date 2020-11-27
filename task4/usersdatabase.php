<?php

class UsersData
{
    public $connect;

    protected final function connect()
    {
        $this->connect = new mysqli("localhost", "root", "sanjeev98", "users");
        if ($this->connect->connect_error) {
            die("Connection failed: " . $this->connect->connect_error);
        }
    }

    protected final function storeUserTable($firstname, $lastname, $mail, $phone_number, $gender, $department, $spoken_language, $speaking_language, $birthday, $address)
    {
        $sql = "INSERT INTO user(firstname,lastname,mail,phone_number,gender,department,speaking_language,birthday,programming_language,address)VALUES ('$firstname','$lastname','$mail','$phone_number','$gender','$department','$spoken_language','$birthday','$speaking_language','$address')";
        if (!($this->connect->query($sql) === TRUE)) {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    protected final function storeSurveyTable($phoneNumber, $media, $hours, $percentage)
    {
        $sql = "INSERT INTO detail(phone_number,media,hours,percentage)VALUES ('$phoneNumber','$media',$hours,$percentage)";
        if (!($this->connect->query($sql) === TRUE)) {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    protected final function getUserTable($value)
    {
        $sql = "SELECT * FROM user where phone_number='$value'";
        $result = $this->connect->query($sql);
        return $result;
    }

    protected final function getSurveyTable($value)
    {
        $sql = "SELECT * FROM detail where phone_number='$value'";
        $result = $this->connect->query($sql);
        return $result;
    }

}

?>
