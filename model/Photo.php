<?php


class Photo implements JsonSerializable {

    public $id;
    public $name;
    public $user_id;
    public $url;



    public function __construct($id, $name, $user_id, $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->user_id = $user_id;
        $this->url = $url;
    }

    public function jsonSerialize()
    {
        return  "{\"id\":\"".$this->id.
        "\",\"name\":\"".$this->name.
        "\",\"url\":\"".$this->url.
        "\",\"user_id\":\"".$this->user_id."\"}";
    }
}