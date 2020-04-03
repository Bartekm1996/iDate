<?php


class Query implements JsonSerializable
{

    private $username;
    private $email;
    private $description;
    private $reason;
    private $date;

    public function __construct($username, $email,$description,$reason,$date)
    {
        $this->username=$username;
        $this->email=$email;
        $this->description=$description;
        $this->reason=$reason;
        $this->date=$date;
    }

    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}