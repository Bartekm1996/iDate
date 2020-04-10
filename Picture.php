<?php
ob_start();
require __DIR__.'/vendor/autoload.php';
require ("db.php");
require ("SweetalertResponse.php");
require ("MongoConnect.php");
$resp = null;

if(isset($_POST['userId']) && isset($_POST['photoUrl'])) {


    header('Content-Type: application/json');


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else {

        $url = $conn->real_escape_string($_POST['photoUrl']);
        $userId = $conn->real_escape_string($_POST['userId']);

        $sql = "UPDATE profile SET photoId = '{$url}' WHERE userID = '{$userId}'";


        if ($conn->query($sql) === TRUE) {

            $resp = new SweetalertResponse(1,
                'Photo Changed Successfully',
                "Your photo has been saved successfully",
                SweetalertResponse::SUCCESS
            );



            $sql = "SELECT userName FROM user WHERE id='{$userId}';";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $res = $result->fetch_row()[0];
                $mongo = new MongoConnect();
                $mongo->historyUpdate($res, 'Profile Picture Change', 'Picture Added');
                $resp->setImg($url);
            }
        } else {
            $resp = new SweetalertResponse(2,
                'Failed To Changed Profile Picture',
                "Your profile picture was not changed",
                SweetalertResponse::SUCCESS
            );
        }

    }

    $conn->close();
    echo $resp->jsonSerialize();
}
ob_start();
