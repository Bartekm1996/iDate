<?php


class Match implements JsonSerializable {

    public $id;
    public $age;
    public $name;
    public $photoId;
    public $location;
    public $desc;
    public $smoker;
    public $drinker;
    public $seeking;
    public $lastname;
    public $gender;
    public $connectionDate;


    public function __construct($id, $name, $age, $gender,$photoId, $location, $desc)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->photoId = $photoId;
        $this->location = $location;
        $this->desc = $desc;
      //  $this->smoker = $smoker;
     //   $this->drinker = $drinker;
     //   $this->lastname = $lastname;
        $this->gender = $gender;
      //  $this->connectionDate = $connectionDate;
    }



    public function jsonSerialize()
    {
        return  "{\"id\":\"".$this->id.
        "\",\"name\":\"".$this->name.
        "\",\"age\":\"".$this->age.
        "\",\"photoId\":\"".$this->photoId.
        "\",\"location\":\"".$this->location.
        "\",\"desc\":\"".$this->desc.
        "\",\"smoker\":\"".$this->smoker.
        "\",\"drinker\":\"".$this->drinker.
        "\",\"seeking\":\"".$this->seeking.
        "\",\"lastname\":\"".$this->lastname.
        "\",\"connectionDate\":\"".$this->connectionDate.
        "\",\"gender\":\"".$this->gender
        ."\"}";
    }
}
