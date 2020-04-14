<?php


class UserInfo implements JsonSerializable
{

    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $descripion;
    private $age;
    private $seeking;
    private $photoId;
    private $gender;
    private $smoker;
    private $dinker;
    private $id;
    private $town;
    private $interest;

    /**
     * UserInfo constructor.
     * @param String $userName
     * @param String $firstName
     * @param String $lastName
     * @param String $email
     * @param $descripion
     * @param $age
     * @param $seeking
     * @param $photoId
     * @param $gender
     * @param $smoker
     * @param $drinker
     * @param $id
     * @param $town
     */
    public function __construct($userName, $firstName, $lastName, $email, $descripion, $age, $seeking, $photoId, $gender, $smoker, $drinker, $id, $town, $interest)
    {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->descripion = $descripion;
        $this->age = $age;
        $this->seeking = $seeking;
        $this->photoId = $photoId;
        $this->gender = $gender;
        $this->smoker = $smoker;
        $this->dinker = $drinker;
        $this->id = $id;
        $this->town = $town;
        $this->interest = $interest;
    }



    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}