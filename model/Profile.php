<?php


class Profile implements JsonSerializable
{
    public $id;
    public $age;
    public $name;
    public $photoId;
    public $location;
    public $desc;
    public $gender;
    public $username;


    public function __construct($id, $name, $age, $gender,$username, $photoId, $location, $desc)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->photoId = $photoId;
        $this->location = $location;
        $this->desc = $desc;
        $this->username = $username;
        $this->gender = $gender;
    }



    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }

}