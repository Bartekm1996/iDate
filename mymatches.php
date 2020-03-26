<?php
require("db.php");


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        //SELECT * FROM user WHERE id IN (SELECT userID2 FROM connections WHERE userID1='66')
        $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.age,
 profile.photoId, profile.location, profile.Description  FROM user
inner join profile
on user.id = profile.userID) 
as res 
WHERE id IN (SELECT userID2 FROM connections WHERE userID1='66')";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                echo"<div class='grid-item'><img src='https://placekitten.com/100/100'/><h4>$row[1]</h4></div>\n";
            }
            echo "\n";
        }

}





