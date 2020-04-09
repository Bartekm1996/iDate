<?php


class UserInfo implements JsonSerializable
{

    private String $userName;
    private String $firstName;
    private String $lastName;
    private String $email;
    private $descripion;
    private $age;
    private $seeking;
    private $photoId;
    private $gender;
    private $smoker;
    private $dinker;
    private $id;

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
     */
    public function __construct($userName, $firstName, $lastName, $email, $descripion, $age, $seeking, $photoId, $gender, $smoker, $drinker, $id)
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
    }



    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}