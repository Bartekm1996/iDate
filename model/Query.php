<?php


class Query implements JsonSerializable
{

    private $username;
    private $email;
    private $description;
    private $reason;
    private $date;
    private $number;
    private $status;
    private $archived;

    public function __construct($username, $email,$description,$reason,$date, $number, $status, $archived)
    {
        $this->username=$username;
        $this->email=$email;
        $this->description=$description;
        $this->reason=$reason;
        $this->date=$date;
        $this->number=$number;
        $this->status=$status;
        $this->archived = $archived;
    }

    public function jsonSerialize()
    {
        return json_encode(get_object_vars($this));
    }
}