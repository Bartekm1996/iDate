<?php

/*
 * user.id, user.firstname, user.age,
profile.photoId, profile.location, profile.Description,
profile.Smoker, profile.Seeking, user.lastname, user.gender
 */
class SearchUser implements JsonSerializable {

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


    public function __construct($id, $name, $age, $photoId, $location, $desc,
        $smoker, $drinker, $seeking, $lastname, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->photoId = $photoId;
        $this->location = $location;
        $this->desc = $desc;
        $this->smoker = $smoker;
        $this->drinker = $drinker;
        $this->seeking = $seeking;
        $this->lastname = $lastname;
        $this->gender = $gender;
    }

    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}
