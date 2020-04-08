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
    public $username;

    /**
     * Match constructor.
     * @param $id
     * @param $age
     * @param $name
     * @param $photoId
     * @param $location
     * @param $desc
     * @param $smoker
     * @param $drinker
     * @param $seeking
     * @param $lastname
     * @param $gender
     * @param $connectionDate
     * @param $username
     */
    public function __construct($id, $age, $name, $photoId, $location, $desc, $smoker, $drinker, $seeking, $lastname, $gender, $connectionDate, $username)
    {
        $this->id = $id;
        $this->age = $age;
        $this->name = $name;
        $this->photoId = $photoId;
        $this->location = $location;
        $this->desc = $desc;
        $this->smoker = $smoker;
        $this->drinker = $drinker;
        $this->seeking = $seeking;
        $this->lastname = $lastname;
        $this->gender = $gender;
        $this->connectionDate = $connectionDate;
        $this->username = $username;
    }


    public function jsonSerialize()
    {
       return json_encode(get_object_vars($this));
    }
}
