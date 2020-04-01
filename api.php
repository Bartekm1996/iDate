<?php
ob_start();

//User this class as the api
require("db.php");
require("model/User.php");
require("model/Photo.php");
require("model/Match.php");
require("model/AvailableInterests.php");
require("model/Connection.php");
/* Create a match with current logged in user and match_id user */
if(isset($_POST['create_match_api']) && isset($_POST['id1']) && isset($_POST['id2'])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $date = date("Y/m/d");
        $sql = "INSERT INTO connections (userID1, userID2, connectionDate) "
            ."VALUES({$_POST['id1']}, {$_POST['id2']}, '{$date}');";
        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else echo "Failed";
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
        }
        $res = $res."];";
        echo $res;
    }
} else if(isset($_POST['get_connections_api']) && isset($_POST['user_id'])) {
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

        //SELECT * FROM user WHERE id IN (SELECT userID2 FROM connections WHERE userID1='66')
        $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.age,
 profile.photoId, profile.location, profile.Description  FROM user
inner join profile
on user.id = profile.userID) 
as res 
WHERE id IN (SELECT userID2 FROM connections WHERE userID1='{$_POST['user_id']}')";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new Match($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
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
        if(isset($_POST['filter'])) {
                        $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.age,
             profile.photoId, profile.location, profile.Description  FROM user
            inner join profile
            on user.id = profile.userID) AS res
            WHERE firstname LIKE '%{$_POST['filter']}%';";
        }else {

                        $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.age,
             profile.photoId, profile.location, profile.Description  FROM user
            inner join profile
            on user.id = profile.userID) as res";
        }

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $user = new Match($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
} else if(isset($_POST['upload_files_api'])) {
    $arr = $_POST["formData"];

    echo json_encode($_FILES['files']);
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

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "SELECT * FROM (SELECT user.id, user.firstname, user.lastname, user.age, user.gender,
             profile.photoId, profile.location, profile.Description  FROM user
            inner join profile
            on user.id = profile.userID) AS res
            WHERE id='{$user_id}';";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $row = $result->fetch_row();
            $user = new Match($row[0], $row[1]." ".$row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
            $res = $user->jsonSerialize();
    }
        echo $res;

    }
}
ob_start();

