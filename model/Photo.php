<?php


class Photo implements JsonSerializable {

    public $id;
    public $name;
    public $url;
    public $user_id;


    public function __construct($id, $name, $url, $user_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->user_id = $user_id;
    }

    public function jsonSerialize()
    {
        return  "{id:\"".$this->id."\",name:\"".$this->name."\",url:\"".$this->url."\",user_id:\"".$this->user_id."\"}";
    }
}