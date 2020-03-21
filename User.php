<?php


class User implements JsonSerializable {

    public $id;
    public $age;
    public $name;


    public function __construct($id, $name, $age)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }

    public function jsonSerialize()
    {
        return  "{id:\"".$this->id."\",name:\"".$this->name."\",age:\"".$this->age."\"}";
    }
}
