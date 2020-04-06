<?php


class UserInfo implements JsonSerializable
{

    private String $userName;
    private String $firstName;
    private String $lastName;
    private String $email;
    private $descripion;
    private $age;

    /**
     * UserInfo constructor.
     * @param $userName
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $descripion
     */
    public function __construct($userName, $firstName, $lastName, $email, $descripion, $age)
    {
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->descripion = $descripion;
        $this->age = $age;
    }


    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}