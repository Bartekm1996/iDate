<?php
//User this class as the api
require("db.php");

session_start();
/* Create a match with current logged in user and match_id user */
if(isset($_POST['create_match_api']) && isset($_POST['match_id'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $date = date("Y/m/d");
        $sql = "INSERT INTO connections (userID1, userID2, connectionDate) "
            ."VALUES({$_SESSION['userid']}, {$_POST['match_id']}, '{$date}');";
        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else echo "Failed";
    }
}