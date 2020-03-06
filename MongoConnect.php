<?php


class MongoConnect
{

    private String $connString;
    private MongoDB\Driver\Manager $connection;


    public function __construct()
    {
        //$this->connString = getenv("");
        $this->connString = "mongodb+srv://Btech96:LeoN1996%40@idate-l8bbf.mongodb.net/test?retryWrites=true&w=majority";
        $this->connection = new MongoDB\Driver\Manager($this->connString);

    }

    public function getConnection(){
        return $this->connection;
    }

    public function __destruct()
    {

    }

}