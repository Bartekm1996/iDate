<?php


class Match implements JsonSerializable {

    public $id;
    public $age;
    public $name;
    public $photoId;
    public $location;
    public $desc;
    public $gender;


    public function __construct($id, $name, $age, $gender, $photoId, $location, $desc)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->photoId = $photoId;
        $this->location = $location;
        $this->desc = $desc;
        $this->gender = $gender;
    }

    public function jsonSerialize()
    {
        return  "{\"id\":\"".$this->id."\",\"name\":\"".$this->name."\",\"age\":\"".$this->age."\",\"gender\":\"".$this->gender."\",\"photoId\":\"".$this->photoId."\",\"location\":\"".$this->location."\",\"desc\":\"".$this->desc."\"}";
    }
}
