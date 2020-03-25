<?php

require "vendor/autoload.php";

class MongoConnect
{

    private String $connString;
    private MongoDB\Driver\Manager $connection;


    public function __construct()
    {
        $this->connString = "mongodb+srv://Btech96:LeoN1996%40@idate-l8bbf.mongodb.net/test?retryWrites=true&w=majority";
        $this->connection = new MongoDB\Driver\Manager($this->connString);
        $this->historyUpdate("guuuu", "huhihiho");
    }

    public function getConnection(){
        return $this->connection;
    }

    public function historyUpdate(String $description, String $type){
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(['timestamp' => (new DateTime)->getTimestamp () ,
            'description' => $description,
            'type' => $type
            ]);
        $this->getConnection()->executeBulkWrite('iDate.history', $bulk);
    }

    public function insertDocument(String $user, Command $command){
        try {
            $this->getConnection()->executeWriteCommand("iDate.history." . $user, $command);
        } catch (\MongoDB\Driver\Exception\Exception $e) {
            echo $e;
        }
    }

    public function __destruct()
    {

    }

}