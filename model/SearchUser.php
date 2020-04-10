<?php

/*
 * user.id, user.firstname, user.age,
profile.photoId, profile.location, profile.Description,
profile.Smoker, profile.Seeking, user.lastname, user.gender
 */
class SearchUser implements JsonSerializable {

    private $id;
    private $age;
    private $name;
    private $photoId;
    private $location;
    private $desc;
    private $smoker;
    private $drinker;
    private $seeking;
    private $lastname;
    private $gender;
    private $town;


    public function __construct($id, $name, $age, $photoId, $location, $desc,
        $smoker, $drinker, $seeking, $lastname, $gender, $town)
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
        $this->town = $town;
    }

    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}
