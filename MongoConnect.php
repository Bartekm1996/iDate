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
    }

    public function getConnection(){
        return $this->connection;
    }

    public function initHistory(String $user){
        $bulk = $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(
                ['_id' => $user,
                    '_events' => [[
                     'timestamp' => date('Y-m-d H:i:s', time()),
                     'description' => 'User registration',
                     'event' => 'registration',
                        ],
                    ],
                ]
            );
        $this->getConnection()->executeBulkWrite('iDate.history', $bulk);
    }

    public function initConversations(String $user){
        $bulk = $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(
            ['_id' => $user,
                '_conversations' => [
                ],
            ]
        );
        $this->getConnection()->executeBulkWrite('iDate.conversations', $bulk);
    }

    public function updateConversations(String $user, String $userTwo, String $message){
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(array('_id'=>$user),array('$push'=> array('conversations'.$user => ['timestamp' => date('Y-m-d H:i:s', time()),'message' => $message,'user'=> $user])));
        $bulk->update(array('_id'=>$userTwo),array('$push'=> array('conversations'.$userTwo => ['timestamp' => date('Y-m-d H:i:s', time()),'message' => $message,'user'=> $user])));
        $this->getConnection()->executeBulkWrite('iDate.conversations', $bulk);
    }

    public function historyUpdate(String $user, String $description, String $type){
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(array('_id'=>$user),array('$push'=> array('_events' => ['timestamp' => date('Y-m-d H:i:s', time()),'description' => $description,'event'=> $type])));
        $this->getConnection()->executeBulkWrite('iDate.history', $bulk);
    }

    public function getConversations(String $user){
        $bulk = new MongoDB\Driver\Query();

    }



    public function __destruct()
    {

    }

}