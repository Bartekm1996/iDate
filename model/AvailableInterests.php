<?php


class AvailableInterests implements JsonSerializable {

    public $id;
    public $name;
    public $picture;


    public function __construct($id, $name, $picture)
    {
        $this->id = $id;
        $this->name = $name;
        $this->picture = $picture;
    }

    public function jsonSerialize()
    {
        return  json_encode(get_object_vars($this));
    }
}
