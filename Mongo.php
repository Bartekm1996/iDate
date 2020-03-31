<?php
ob_start();
require ('MongoConnect.php');
require ('SweetalertResponse.php');

if(isset($_GET['userId'])){
    $mongo = new MongoConnect();

    $result = $mongo->getConversations();
    $myObj = array();

    if(isset($_GET['messages'])){
        foreach ($result as $document) {
            for ($x = 0; $x < sizeof($document->_conversations[$_GET['messages']]->messages); $x++) {
                    array_push($myObj, array(
                        "username" => $document->_conversations[$_GET['messages']]->messages[$x]->username,
                        "message" => $document->_conversations[$_GET['messages']]->messages[$x]->message,
                        "timestamp" => $document->_conversations[$_GET['messages']]->messages[$x]->timestamp
                    ));
            }
        }
        echo json_encode(array("messages" => $myObj));

    }else {
        foreach ($result as $document) {
            for ($x = 0; $x < sizeof($document->_conversations); $x++) {
                array_push($myObj, array(
                    "username" => $document->_conversations[$x]->username,
                    "message" => $document->_conversations[$x]->messages[sizeof($document->_conversations[$x]->messages)-1]->message,
                    "id" => $x
                    ));
            }
        }
        echo json_encode(array("contacts" => $myObj));
    }

}else {
    /*
    request.userOne = 'Bartekm1999';
    request.userTwoId = $('ul#contactsList').find('li.active').attr("data-id");
    request.userTwoName = $('ul#contactsList').find('li.active').attr("data-user-name");
    request.messages = message;
    */
    if(isset($_GET['userOne']) && isset($_GET['userTwoId']) && isset($_GET['userTwoName']) && isset($_GET['messages'])) {
        $mongo = new MongoConnect();
        $written = false;
        $result = $mongo->updateConversations($_GET['userOne'], $_GET['userTwoId'], $_GET['userTwoName'], $_GET['messages']);


        if ($result->isAcknowledged()) {
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
