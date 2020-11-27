<?php
require_once "usersdatabase.php";
require_once "interface.php";

class SurveyDetail extends User implements UserValue
{
    public $phoneNumber,$media,$hours,$percentage;

    public function __construct($phoneNumber, $media, $hours)
    {
        $this->phoneNumber = $phoneNumber;
        $this->media = $media;
        $this->hours = $hours;
        $this->percentage = round(($this->hours / 24) * 100);
    }

    public function getConnect()
    {
        $this->connect();
    }

    public function storeSurveyDetail()
    {
        $this->storeSurveyTable($this->phoneNumber, $this->media, $this->hours, $this->percentage);
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function getPercentage()
    {
        return $this->percentage;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function getUserValue()
    {
        $result = $this->getSurveyTable($this->phoneNumber);
        print_r($result->fetch_array());
    }
}
?>