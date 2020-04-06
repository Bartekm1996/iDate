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
/* Create a match with current logged in user and match_id user */
if(isset($_POST['create_match_api']) && isset($_POST['id1']) && isset($_POST['id2'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $heart = "";
        $date = date("Y/m/d");
        $sql = "INSERT INTO connections (userID1, userID2, connectionDate) "
            ."VALUES({$_POST['id1']}, {$_POST['id2']}, '{$date}');";
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT userID2 FROM connections where userID1 = '{$_POST['id1']}'";
            $res = $conn->query($sql);
            if($res->num_rows > 0){
                $heart = new SweetalertResponse(1,
                    'Congratulations !!!!!',
                    "We have a match",
                    SweetalertResponse::SUCCESS
                );
            }else{
                $heart = new SweetalertResponse(2,
                    'Congratulations ',
                    "Hopefully you'll match",
                    SweetalertResponse::SUCCESS
                );
            }
            echo $heart->jsonSerialize();
        }
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
                $user = new AvailableInterests($row[0], $row[1]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}else if(isset($_POST['get_my_interests_api']) && isset($_POST['userid'])) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "select availableInterests.id, availableInterests.name from interests as a1
                inner join availableInterests on a1.interestID = availableInterests.id
                where a1.userID ={$_POST['userid']}";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new AvailableInterests($row[0], $row[1]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
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
        $sql = "select user.id, user.firstname, user.age, 
                profile.photoId, profile.location, profile.Description,
                profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender,
                results.connectionDate
                from (select c1.id, c1.userID1, c1.userID2, c1.connectionDate
                from connections as c1, connections as c2
                where (c1.userID1 = c2.userID2 AND 
                c2.userID1 = c1.userID2) AND
                c1.userID2 = '{$_POST['user_id']}') as results
                inner join profile on results.userID1 = profile.userID
                inner join user on results.userID1 = user.id;";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {

            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new Match($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++],
                    $row[$i++],$row[$i++],$row[$i++],$row[$i++], $row[$i++], $row[$i++]);

                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
} else if(isset($_POST['get_profiles_api'])) { //add gender search
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        //SELECT * FROM user WHERE id IN (SELECT userID2 FROM connections WHERE userID1='66')

        $id = $conn->real_escape_string($_POST['user_id']);

        if(isset($_POST['filter'])) {

            $sql = "SELECT  * FROM (SELECT * FROM (SELECT user.id, user.firstname, user.age,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender
                 FROM user
                 inner join profile
                 on user.id = profile.userID where profile.Seeking <> user.gender) AS res where id <> '{$id}'
                 AND gender = (SELECT Seeking from profile where userID = '{$id}')) as res WHERE firstname LIKE '%{$_POST['filter']}%';";


        }else {

            $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.age,
                 profile.photoId, profile.location, profile.Description,
                 profile.Smoker, profile.Drinker, profile.Seeking, user.lastname, user.gender
                 FROM user
                 inner join profile
                 on user.id = profile.userID where profile.Seeking <> user.gender) AS res where id <> '{$id}' AND gender = (SELECT Seeking from profile where userID = '{$id}');";
        }

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new SearchUser($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++],
                    $row[$i++], $row[$i++],$row[$i++],$row[$i++],$row[$i++],$row[$i++]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
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
                    $row[$i++], $row[$i++],$row[$i++],$row[$i++],$row[$i++],$row[$i++]);
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
            $sqlInterest = "SELECT Seeking FROM profile WHERE userID = 170;";
            $result = $conn->query($sqlInterest);

            if ($result->num_rows > 0) {
                $resp = $result->fetch_row()[0];
                $user_interest = $conn->real_escape_string(ucfirst($resp));
                $result->free_result();
                $sqlPotInterest = "SELECT id FROM user where gender = '{$user_interest}'";
                $result = $conn->query($sqlPotInterest);
                if ($result->num_rows > 0){
                    while($row = mysqli_fetch_row($result)){
                        $res = $res.$row[0].",";
                    }
                    $res = $res."]";

                }
                $_SESSION['possible_matches'] = $res;
                echo $res;

            }

    }
}else if(isset($_POST['get_user_profile_api'])){
    $user_id = $conn->real_escape_string($_POST['userId']);

    $res = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.lastname, user.age, user.gender, user.userName, 
             profile.photoId, profile.location, profile.Description  FROM user
            inner join profile
            on user.id = profile.userID) AS res
            WHERE id='{$user_id}';";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $row = $result->fetch_row();
            $user = new Match($row[0], $row[1]." ".$row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]);
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
    $status = $conn->real_escape_string($_POST['date']);
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
}
ob_start();

