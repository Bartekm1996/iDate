<?php
session_start();
ob_start();

//User this class as the api
require("db.php");
require("model/User.php");
require("model/Photo.php");
require("model/Match.php");
require("model/SearchUser.php");
require("model/AvailableInterests.php");
require("model/Connection.php");
require("SweetalertResponse.php");
require("model/Profile.php");
require("MongoConnect.php");
require("model/UserInfo.php");
require ("Email.php");
/* Create a match with current logged in user and match_id user */
if(isset($_POST['create_match_api']) && isset($_POST['id1']) && isset($_POST['id2'])) {

    $matched = false;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $heart = "";$matched = false;
        $date = date("Y/m/d");
        $sqlCheckMatch = "SELECT userID1,userID2 FROM connections WHERE userID1 = '{$_POST['id2']}' AND userID2 = '{$_POST['id1']}';";
        $sqlMatch = "INSERT INTO connections (userID1, userID2, connectionDate) VALUES({$_POST['id1']}, {$_POST['id2']}, '{$date}');";

        $i = 0;
        $res = $conn->query($sqlCheckMatch);
        if($res->num_rows > 0){
            while($row = mysqli_fetch_row($res)){
                if($row[0] === $_POST['id2'] && $row[1] === $_POST['id1']){
                    $matched = true;
                    $sql = "SELECT userName FROM user WHERE id = '{$_POST['id1']}';";
                    $usersNameOne = $conn->query($sql)->fetch_row()[0];

                    $sql = "SELECT userName FROM user WHERE id = '{$_POST['id2']}';";
                    $usersNameTwo = $conn->query($sql)->fetch_row()[0];

                    $mongo = new MongoConnect();
                    $mongo->historyUpdate($usersNameOne, "You matched with ". $usersNameTwo, "New Match");
                    $mongo->historyUpdate($usersNameTwo, "You matched with ". $usersNameOne, "New Match");

                }
            }
        }
        $conn->query($sqlMatch);

        if($matched === false){
            $heart = new SweetalertResponse(2,
                'Congratulations ',
                "Hopefully you'll match",
                SweetalertResponse::SUCCESS
            );
        }else{
            $heart = new SweetalertResponse(1,
                'Congratulations !!!!!',
                "We have a match",
                SweetalertResponse::SUCCESS
            );
        }


        echo $heart->jsonSerialize();

    }
} else if(isset($_POST['get_all_users_api'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //check is username is taken
        $sql = "SELECT id, firstname, age FROM user;";
        $users = [];

        $result = $conn->query($sql);

        $idx = 0;
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new User($row[0], $row[1], $row[2]);
                //$users[$idx++] = $user;
                $res = $res.$user->jsonSerialize().",";
            }
            $res = $res."];";
            echo $res;
        }

    }
} else if(isset($_POST['get_user_images_api']) && isset($_POST['user_id'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //check is username is taken
        $sql = "SELECT * FROM photo WHERE user_id = '{$_POST['user_id']}';";

        $result = $conn->query($sql);

        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new Photo($row[0], $row[1], $row[2], $row[3]);
                $res = $res.$user->jsonSerialize().",";
            }
        }
        $res = $res."];";
        echo $res;
    }
}  else if(isset($_POST['get_available_interests_api'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //check is username is taken
        $sql = "SELECT * FROM availableInterests;";

        $result = $conn->query($sql);

        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new AvailableInterests($row[0], $row[1], $row[2]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}else if(isset($_POST['get_my_interests_api']) && isset($_POST['userid'])) {

    $myobs = array();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "select availableInterests.id, availableInterests.name, availableInterests.picture from interests as a1
                inner join availableInterests on a1.interestID = availableInterests.id
                where a1.userID ={$_POST['userid']}";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new AvailableInterests($row[0], $row[1], $row[2]);
                array_push($myobs, $user->jsonSerialize());
            }
        }
        echo json_encode(array("ints" => $myobs));
    }
}  else if(isset($_POST['update_available_interests_api']) && isset($_POST['userid'])
&& isset($_POST['interest']) && isset($_POST['add'])){

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //we need the id of the item to link FK
        $sql = "SELECT * FROM availableInterests where name='{$_POST['interest']}' LIMIT 1";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);

            //check that we have this item item
            $sql = "SELECT interestID FROM interests where userID='{$_POST['userid']}' AND interestID={$row[0]}  LIMIT 1";
            //delete up insert
            $insertOrDelete = $_POST['add'] == 'true' ? "insert into interests (userID, interestID) VALUES ({$_POST['userid']}, {$row[0]});"
                : "DELETE FROM interests WHERE userID={$_POST['userid']} AND interestID = {$row[0]};";
            $result = $conn->query($insertOrDelete);
            echo "success";
        }

    }
}else if(isset($_POST['updates_users_interests'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $id = $conn->real_escape_string($_POST['userId']);
        $names = $_POST['newNodes'];
        $sql = "DELETE FROM interests WHERE userID = '{$id}'";
        $counter = 0;
        $resp = "";
        if($conn->query($sql) === TRUE){
            for($x = 0; $x < sizeof($names); $x++){
                if($conn->query("INSERT INTO interests(userID, interestID) VALUES('{$id}',(SELECT id FROM availableInterests WHERE name = '{$names[$x]}'));") === TRUE){
                    $counter++;
                }
            }
        }

        if($counter === sizeof($names)){
            $resp = new SweetalertResponse(2,
                'Interest Updated Successfully',
                "Updated Interests With Success",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(3,
                'Failed to Updated Interests',
                "Failed to Updated Users Interests",
                SweetalertResponse::ERROR
            );
        }
        echo $resp->jsonSerialize();
    }
}
else if(isset($_POST['get_connections_api']) && isset($_POST['user_id'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        //SELECT * FROM user WHERE id IN (SELECT userID2 FROM connections WHERE userID1='66')
        $sql = "SELECT * FROM connections WHERE userID1='{$_POST['user_id']}';";

        $result = $conn->query($sql);

        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new Connection($row[0], $row[1], $row[2], $row[3]);
                $res = $res.$user->jsonSerialize().",";
            }

        }
        $res = $res."];";
        echo $res;
    }
}else if(isset($_POST['get_user_matches_api']) && isset($_POST['user_id'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        /* In english this query would be:
            Select all for connections where userID1 has matched with userID2
            AND and store in results. (Both have to like eachother so there would be 2 inserts)

            join results with user and profile table and select the data from
            the person we have matched with
        */
        $myobj = array();
        $sql = "";
        if(isset($_POST['filter'])){
            $filter = $conn->real_escape_string($_POST['filter']);
            $sql = "SELECT * FROM (select user.id, user.firstname, user.age,
                profile.photoId, profile.location, profile.Description,
                profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender,
                results.connectionDate, user.userName, town
                from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                from connections as c1, connections as c2
                where (c1.userID1 = c2.userID2 AND
                c2.userID1 = c1.userID2) AND
                c1.userID2 = '{$_POST['user_id']}') as results
                inner join profile on results.userID1 = profile.userID
                inner join user on results.userID1 = user.id inner join town t on profile.location = t.id) as user WHERE firstname LIKE '%{$filter}%' OR lastname LIKE '%{$filter}%';";
        }else{
            $sql = "select user.id, user.firstname, user.age, 
                profile.photoId, profile.location, profile.Description,
                profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender,
                results.connectionDate, user.userName, town
                from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                from connections as c1, connections as c2
                where (c1.userID1 = c2.userID2 AND 
                c2.userID1 = c1.userID2) AND
                c1.userID2 = '{$_POST['user_id']}')as results
                inner join profile on results.userID1 = profile.userID
                inner join user on results.userID1 = user.id inner join town t on profile.location = t.id;";
        }


        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new Match($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++],
                    $row[$i++],$row[$i++],$row[$i++],$row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++]);

               array_push($myobj, $user->jsonSerialize());
            }

        }

        echo json_encode($myobj);
    }
} else if(isset($_POST['get_profiles_api'])) { //add gender search

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $myobj = array();

        $id = $conn->real_escape_string($_POST['user_id']);

        if(isset($_POST['filter'])) {
            $filter = $conn->real_escape_string($_POST['filter']);
            $sql = "CALL GetUserPreference('{$id}','{$filter}')";
        }else {
            $sql = "CALL GetUserPreferences('{$id}')";
        }

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new SearchUser($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++],
                    $row[$i++], $row[$i++],$row[$i++],$row[$i++],$row[$i++],$row[$i++], $row[$i++]);
                array_push($myobj, $user->jsonSerialize());
            }
        }
        echo json_encode($myobj);
    }
}
else if(isset($_POST['upload_files_api'])) {
    $arr = $_POST["formData"];

    echo json_encode($_FILES['files']);
} else if(isset($_POST['get_userprofiles_api']) && isset($_POST['userid'])) { //add gender search
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "SELECT user.id, user.firstname, user.age,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking,
                 user.lastname, user.gender
                 FROM user
                 inner join profile
                 on user.id = profile.userID
                 WHERE user.id = {$_POST['userid']}";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
                $i = 0;
                $user = new SearchUser($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++],
                    $row[$i++], $row[$i++],$row[$i++],$row[$i++],$row[$i++],$row[$i++], null);
                echo  $user->jsonSerialize();
        } else {
            echo "{}";
        }


    }
} else if(isset($_POST['get_matches_api'])){

        $user_id = $conn->real_escape_string($_POST['userId']);
        $res = "[";

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "CALL GetUserPreferences('{$user_id}')";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_row($result)) {
                        $res = $res . $row[0] . ",";
                }
                $res = $res . "]";
            }
            $_SESSION['possible_matches'] = $res;
            echo $res;
        }
}else if(isset($_POST['get_user_profile_api'])){
    $user_id = $conn->real_escape_string($_POST['userId']);

    $res = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "SELECT * FROM(SELECT * FROM (SELECT user.id as userId, user.firstname, user.lastname, user.age, user.gender, user.userName,
             profile.photoId, profile.location, profile.Description, profile.Drinker, profile.Smoker FROM user
            inner join profile
            on user.id = profile.userID) AS res INNER JOIN town on town.id = res.location) as ress
            WHERE ress.userId='{$user_id}';";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $row = $result->fetch_row();
            $user = new Profile($row[0], $row[1]." ".$row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[12]);
            $res = $user->jsonSerialize();
    }
        echo $res;

    }
}else if(isset($_POST['send_query_message'])){

    $user_name = $conn->real_escape_string($_POST['userName']);
    $user_email = $conn->real_escape_string($_POST['userEmail']);
    $user_desc = $conn->real_escape_string($_POST['userDesc']);
    $user_reason = $conn->real_escape_string($_POST['userReason']);
    $date = $conn->real_escape_string($_POST['date']);
    $status = $conn->real_escape_string($_POST['status']);
    $number = "";
    $archieved = $conn->real_escape_string(false);

    if(isset($_POST['number'])){
        $number = $conn->real_escape_string($_POST['number']);
    }else{
        $number = rand();
    }

    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "INSERT INTO queries (userName, email, description, reason, date, queryNumber, status, archived) VALUES('{$user_name}','{$user_email}','{$user_desc}','{$user_reason}','{$date}','{$number}','{$status}', '{$archieved}')";
        if ($conn->query($sql) === TRUE) {
            $resp = new SweetalertResponse(3,
                'Message Sent',
                "Message was sent successfully",
                SweetalertResponse::SUCCESS
            );
        }else {
            $resp = new SweetalertResponse(3,
                'Failed to send message',
                "Failed to send message",
                SweetalertResponse::ERROR
            );
        }
    }
    echo $resp->jsonSerialize();
} else if(isset($_POST['logout_api'])) {
    session_unset($_SESSION['userid']);
    session_destroy();
    //header("Location: index.php");
    echo 'logged out';
} else if(isset($_POST['filter_get_users'])){
    $resultantArray = [];
    $sql = "";$newStringBuilder = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sex = $conn->real_escape_string($_POST['gender']);
        $seeking = $conn->real_escape_string($_POST['seeking']);
        $userId = $conn->real_escape_string($_POST['userId']);

        if(isset($_POST['interests'])){
            if (strtolower($sex) === strtolower($seeking)) {
                $sql = "SELECT * FROM(SELECT ress.userName, ress.firstname, ress.lastname, ress.email, ress.Description, ress.age,
                 ress.Seeking, ress.photoId, ress.gender, ress.Smoker, ress.Drinker,
                 ress.userId, ress.town, aI.name FROM(SELECT ress.userName, ress.firstname, ress.lastname, ress.email, ress.Description, ress.age,
                 ress.Seeking, ress.photoId, ress.gender, ress.Smoker, ress.Drinker,
                 ress.userId, ress.town FROM (SELECT * FROM (SELECT * FROM (SELECT user.id as userId, user.firstname, user.age, user.userName, user.email,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender
                 FROM user INNER JOIN profile on user.id = profile.userID WHERE user.id <> '{$userId}') as res WHERE res.Seeking = '{$seeking}' AND res.gender = '{$sex}')
                 as res INNER JOIN town on res.location = town.id) as ress WHERE ress.userId not in (select user.id from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                 from connections as c1, connections as c2
                 where (c1.userID1 = c2.userID2 AND
                 c2.userID1 = c1.userID2) AND
                 c1.userID2 = '{$userId}')as results
                 inner join profile on results.userID1 = profile.userID
                 inner join user on results.userID1 = user.id) AND ress.userId not in (SELECT userID1 FROM
                 connections WHERE userID2 = '{$userId}') GROUP BY ress.userId) as ress INNER JOIN interests on
                 interests.userID = ress.userId INNER JOIN availableInterests aI on interests.interestID = aI.id) as ress";
            } else {
                $sql = "SELECT * FROM(SELECT ress.userName, ress.firstname, ress.lastname, ress.email, ress.Description, ress.age,
                 ress.Seeking, ress.photoId, ress.gender, ress.Smoker, ress.Drinker,
                 ress.userId, ress.town, aI.name FROM(SELECT ress.userName, ress.firstname, ress.lastname, ress.email, ress.Description, ress.age,
                 ress.Seeking, ress.photoId, ress.gender, ress.Smoker, ress.Drinker,
                 ress.userId, ress.town FROM (SELECT * FROM (SELECT * FROM (SELECT user.id as userId, user.firstname, user.age, user.userName, user.email,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender
                 FROM user INNER JOIN profile on user.id = profile.userID WHERE user.id <> '{$userId}') as res WHERE res.Seeking <> '{$seeking}' AND res.gender <> '{$sex}')
                 as res INNER JOIN town on res.location = town.id) as ress WHERE ress.userId not in (select user.id from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                 from connections as c1, connections as c2
                 where (c1.userID1 = c2.userID2 AND
                 c2.userID1 = c1.userID2) AND
                 c1.userID2 = '{$userId}')as results
                 inner join profile on results.userID1 = profile.userID
                 inner join user on results.userID1 = user.id) AND ress.userId not in (SELECT userID1 FROM
                 connections WHERE userID2 = '{$userId}') GROUP BY ress.userId) as ress INNER JOIN interests on
                 interests.userID = ress.userId INNER JOIN availableInterests aI on interests.interestID = aI.id) as ress";
            }
        }else {
            if (strtolower($sex) === strtolower($seeking)) {
                $sql = " SELECT * FROM(SELECT  ress.userName, ress.firstname, ress.lastname, ress.email, ress.Description, ress.age,
                 ress.Seeking, ress.photoId, ress.gender, ress.Smoker, ress.Drinker,
                 ress.userId, ress.town FROM (SELECT * FROM (SELECT * FROM (SELECT user.id as userId, user.firstname, user.age, user.userName, user.email,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender
                 FROM user INNER JOIN profile on user.id = profile.userID WHERE user.id <> '{$userId}') as res WHERE res.Seeking = '{$seeking}' AND res.gender = '{$sex}')
                 as res INNER JOIN town on res.location = town.id) as ress WHERE ress.userId not in (select user.id from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                 from connections as c1, connections as c2
                 where (c1.userID1 = c2.userID2 AND
                 c2.userID1 = c1.userID2) AND
                 c1.userID2 = '{$userId}')as results
                 inner join profile on results.userID1 = profile.userID
                 inner join user on results.userID1 = user.id) AND ress.userId not in (SELECT userID1 FROM
                 connections WHERE userID2 = '{$userId}') GROUP BY ress.userId) as ress";


            } else {
                $sql = " SELECT * FROM(SELECT  ress.userName, ress.firstname, ress.lastname, ress.email, ress.Description, ress.age,
                 ress.Seeking, ress.photoId, ress.gender, ress.Smoker, ress.Drinker,
                 ress.userId, ress.town FROM (SELECT * FROM (SELECT * FROM (SELECT user.id as userId, user.firstname, user.age, user.userName, user.email,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender
                 FROM user INNER JOIN profile on user.id = profile.userID WHERE user.id <> '{$userId}') as res WHERE res.Seeking <> '{$seeking}' AND res.gender <> '{$sex}')
                 as res INNER JOIN town on res.location = town.id) as ress WHERE ress.userId not in (select user.id from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                 from connections as c1, connections as c2
                 where (c1.userID1 = c2.userID2 AND
                 c2.userID1 = c1.userID2) AND
                 c1.userID2 = '{$userId}')as results
                 inner join profile on results.userID1 = profile.userID
                 inner join user on results.userID1 = user.id) AND ress.userId not in (SELECT userID1 FROM
                 connections WHERE userID2 = '{$userId}') GROUP BY ress.userId) as ress";
            }
        }

        $stringBuilder = [];


        if(isset($_POST['smoker'])){
            $smoker = $conn->real_escape_string($_POST['smoker']);
            array_push($stringBuilder," ress.Smoker = '{$smoker}' ");
        }

        if(isset($_POST['drinker'])){
            $drinker = $conn->real_escape_string($_POST['drinker']);
            array_push($stringBuilder," ress.Drinker = '{$drinker}' ");
        }

        if(isset($_POST['minValue'])){
            $age = $conn->real_escape_string($_POST['minValue']);
            $ageMax = $conn->real_escape_string($_POST['maxValue']);
            array_push($stringBuilder, " ress.age >= '{$age}' AND ress.age < '{$ageMax}' ");
        }

        if(isset($_POST['city'])){
            $city = $conn->real_escape_string($_POST['city']);
            array_push($stringBuilder, " ress.town = '{$city}' ");
        }

        if(isset($_POST['input'])){
            $input = $conn->real_escape_string($_POST['input']);
            array_push($stringBuilder, " firstname LIKE '%{$input}%' ");
        }

        $size = sizeof($stringBuilder);
        if($size > 0){
            $newStringBuilder = $newStringBuilder." WHERE ";
        }
        for($x = 0; $x < sizeof($stringBuilder); $x++){
            if($x === ($size-1)){
                $newStringBuilder = $newStringBuilder.$stringBuilder[$x];
            }else{
                $newStringBuilder = $newStringBuilder.$stringBuilder[$x]."AND";
            }
        }
        $newStringBuilder = $newStringBuilder.";";

        $sql = $sql.$newStringBuilder;



        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = mysqli_fetch_row($result)){
                if(isset($_POST['interests'])) {
                    $res = new UserInfo($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13]);
                    array_push($resultantArray, $res->jsonSerialize());
                }else {
                    $res = new UserInfo($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], null);
                    array_push($resultantArray, $res->jsonSerialize());
                }
            }
        }
    }
    echo json_encode($resultantArray);
}else if(isset($_POST['get_picture'])){
    $user_id = $conn->real_escape_string($_POST['username']);

    $res = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "SELECT photoId FROM profile WHERE userID = (SELECT id FROM user WHERE userName = '{$user_id}')";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $res = $result->fetch_row()[0];
        }
        echo $res;
    }
}else if(isset($_POST['password_reset_email'])) {
    $rname = $_POST['reset_uname'];
    $remail = $_POST['reset_email'];
    $semail = new Email($remail, $rname);
    $semail->sendRegisterEmail(Email::RESET_PASSWORD);
}else if(isset($_POST['g_recaptcha_response'])){

    $resp = 0;
    $secret = '6LeA9OsUAAAAALJqSZa3xKj9bQdHgE-FyiTS0F02';
    //get verify response data
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g_recaptcha_response']);
    $responseData = json_decode($verifyResponse);
    if($responseData->success) {
        $resp = 1;
    }else{
        $resp = 2;
    }

    echo json_encode(array("status" => $resp));
}
ob_start();

