<?php

class UserManagment implements JsonSerializable
{

    private $userId;
    private $userName;
    private $name;
    private $email;
    private $registered;
    private $blocked;
    private $admin;
    private $photoId;
    private $gender;
    private $town;

    public function __construct($userId,$userName,$name,$email,$blocked,$registered,$admin, $photoId, $gender, $town)
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->name = $name;
        $this->email = $email;
        $this->registered = $registered;
        $this->blocked = $blocked;
        $this->admin = $admin;
        $this->photoId=$photoId;
        $this->gender=$gender;
        $this->town = $town;
    }

    public function jsonSerialize()
    {
        return  json_encode(get_object_vars($this));
    }
}