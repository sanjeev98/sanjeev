<?php
require_once "interface.php";
require_once "usersdatabase.php";

class UserDetail extends Users implements UserValue
{
    public $firstname, $lastname, $mail, $phone_number, $gender, $department, $speaking_language, $programing_language, $birthday, $address;

    function __construct($firstname, $lastname, $mail, $phone_number, $gender, $department, $speaking_language, $programing_language, $birthday, $address)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->mail = $mail;
        $this->phone_number = $phone_number;
        $this->gender = $gender;
        $this->department = $department;
        $this->speaking_language = $speaking_language;
        $this->programing_language = $programing_language;
        $this->birthday = $birthday;
        $this->address = $address;
    }

    public function getconnect()
    {
        $this->connect();
    }

    public function storeUserDetail()
    {
        $this->StoreUserTable($this->firstname, $this->lastname, $this->mail, $this->phone_number, $this->gender, $this->department, $this->speaking_language, $this->programing_language, $this->birthday, $this->address);
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getProgramingLanguage()
    {
        return $this->programing_language;
    }

    public function getSpeakingLanguage()
    {
        return $this->speaking_language;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getUserValue()
    {
        $result = $this->getUserTable($this->phone_number);
        print_r($result->fetch_array());
    }
}

?>