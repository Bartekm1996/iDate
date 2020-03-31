<?php


class AvailableInterests implements JsonSerializable {

    public $id;
    public $name;


    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return  "{\"id\":\"".$this->id."\",\"name\":\"".$this->name."\"}";
    }
}
