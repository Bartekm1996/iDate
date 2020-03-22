<?php


class Connection implements JsonSerializable {

    public $id;
    public $userID1;
    public $userID2;
    public $connectionDate;


    public function __construct($id, $userID1, $userID2, $connectionDate)
    {
        $this->id = $id;
        $this->userID1 = $userID1;
        $this->userID2 = $userID2;
        $this->connectionDate = $connectionDate;
    }

    public function jsonSerialize()
    {
        return  "{id:\"".$this->id."\",userID1:\"".$this->userID1."\",userID2:\"".$this->userID2."\",connectionDate:\"".$this->connectionDate."\"}";
    }
}
