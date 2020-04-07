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

    public function getLastLoggedIn(String $user){
        $filter = ['_id' => $user];
        $options = [];
        $query = new MongoDB\Driver\Query($filter, $options);
        try {
            return $this->getConnection()->executeQuery('iDate.history', $query);
        } catch (\MongoDB\Driver\Exception\Exception $e) {

        }
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

    /*
     * $answers->update(array('userId' => 1, 'questions.questionId' => '1'), array('$push' => array('questions.$.ans' => 'try2')));
     */

    public function initUsersConversation(String $user, String $recievingUser,  String $message){
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(array('_id'=>$user),array('$push'=>array('_conversations' => ['username'=> $user, 'message' => $message,'timestamp' => date('Y-m-d H:i:s', time())])));
        $bulk->update(array('_id'=>$recievingUser,), array('$push' => array('_conversations' => ["username" => $user, "messages" => ['username'=> $user, 'message' => $message,'timestamp' => date('Y-m-d H:i:s', time())]])));
        return $this->getConnection()->executeBulkWrite('iDate.conversations', $bulk);
    }

    public function updateConversations(String $user, String $userTwoName,  String $message){
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(array('_id'=>$user, '_conversations.username' => $userTwoName ),array('$push'=>array('_conversations.$.messages' => ['username'=> $user, 'message' => $message,'timestamp' => date('Y-m-d H:i:s', time())])));
        $bulk->update(array('_id'=>$userTwoName, '_conversations.username' => $user), array('$push' => array('_conversations.$.messages' => ["username" => $user, "messages" => ['username'=> $user, 'message' => $message,'timestamp' => date('Y-m-d H:i:s', time())]])));
        return $this->getConnection()->executeBulkWrite('iDate.conversations', $bulk);

    }

    public function historyUpdate(String $user, String $description, String $type){
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(array('_id'=>$user),array('$push'=> array('_events' => ['timestamp' => date('Y-m-d H:i:s', time()),'description' => $description,'event'=> $type])));
        $this->getConnection()->executeBulkWrite('iDate.history', $bulk);
    }

    public function getConversations(String $user){
        $filter = ['_id' => $user];
        $options = [];
        $query = new MongoDB\Driver\Query($filter, $options);
        try {
            return $this->getConnection()->executeQuery('iDate.conversations', $query);
        } catch (\MongoDB\Driver\Exception\Exception $e) {

        } // $mongo contains the connection object to MongoDB
    }



    public function __destruct()
    {

    }

}