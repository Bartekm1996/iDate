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
        $name = $conn->real_escape_string("userProfilePhoto");
        $userId = $conn->real_escape_string($_POST['userId']);


        $sqlInsert = "INSERT INTO photo (name, user_id, url) VALUES('{$name}','{$userId}','{$url}');";

        $sqlUpdate = "UPDATE photo SET url = '{$url}' WHERE id = {$userId} AND name = '{$name}'";

        $sql = "SELECT name FROM photo WHERE id='{$userId}'";

        $sqlSmnt = $conn->query($sql)->num_rows > 0 ? $sqlUpdate : $sqlInsert;


        if (mysqli_query($conn, $sqlSmnt)) {

            $resp = new SweetalertResponse(1,
                'Photo Changed Successfully',
                "Your photo has been saved successfully",
                SweetalertResponse::SUCCESS
            );

            $resp->setImg($url);


            $sql = "SELECT userName FROM user WHERE id='{$userId}';";
            $result = $conn->query($sql);
            $res = $result->fetch_row()[0];

            $mongo = new MongoConnect();
            $mongo->historyUpdate($res, 'Profile Picture Change', 'Picture Added');

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
