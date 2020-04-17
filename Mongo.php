<?php
ob_start();
require ('MongoConnect.php');
require ('SweetalertResponse.php');

if(isset($_GET['userId'])){
    $mongo = new MongoConnect();

    $result = $mongo->getConversations($_GET['userId']);
    $myObj = array();

    echo json_encode($result->toArray());

}else if(isset($_GET['last_logged_in'])){

    $mongo = new MongoConnect();
    $result = $mongo->getLastLoggedIn($_GET['username']);
    $myres = array();
    $index = 0;


    foreach($result as $document){
        $index = (sizeof($document->_events) > 15 ? (sizeof($document->_events) - 15) : 0);

            for ($x = $index; $x < sizeof($document->_events); $x++) {
                array_push($myres, array(
                    "timestamp" => $document->_events[$x]->timestamp,
                    "description" => $document->_events[$x]->description,
                    "event" => $document->_events[$x]->event
                ));
            }

            echo json_encode(array("events" => $myres));

    }


} else {
    /*
    request.userOne = 'Bartekm1999';
    request.userTwoId = $('ul#contactsList').find('li.active').attr("data-id");
    request.userTwoName = $('ul#contactsList').find('li.active').attr("data-user-name");
    request.messages = message;
    */
    if(isset($_GET['userOne']) && isset($_GET['userTwoId']) && isset($_GET['userTwoName']) && isset($_GET['messages']) && isset($_GET['size'])) {
        $mongo = new MongoConnect();

        if(((int)$_GET['size']) > 0){
            $result = $mongo->updateConversations($_GET['userOne'], $_GET['userTwoName'], $_GET['messages']);
        }else if((int)$_POST['size'] === 0){
            $result = $mongo->initUsersConversation($_GET['userOne'], $_GET['userTwoName'], $_GET['messages']);
        }


        if ($result->getInsertedCount() !== null) {
            $resp = new SweetalertResponse(1,
                'Message Sent',
                "Message Sent",
                SweetalertResponse::SUCCESS
            );
        }else {
            $resp = new SweetalertResponse(2,
                'Message Not Sent',
                "Message Not Sent",
                SweetalertResponse::ERROR
            );
        }
        echo $resp->jsonSerialize();
    }
}
ob_end_flush();
