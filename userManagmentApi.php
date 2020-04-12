<?php
ob_start();
require ('db.php');
require ('model/UserManagment.php');
require ('model/Query.php');
require ('SweetalertResponse.php');
require("Email.php");
require ("model/UserInfo.php");
require ("model/BlockReason.php");


if(isset($_POST['get_all_users'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "SELECT user_id,userName,firstname,lastname,email,blocked,registered,admin,photoId,gender, town FROM
                (SELECT a.id as user_id, a.userName, a.firstname, a.lastname, a.email, a.registered,a.admin, b.userID, b.blocked, b.photoId,a.gender, b.location
                FROM user as a LEFT JOIN(select userID, blocked,photoId, location from profile group by userID) as b on a.id = b.userID) as users INNER JOIN town on town.id = users.location;";

        $result = $conn->query($sql);
        $res = [];
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new UserManagment($row[$i++], $row[$i++], $row[$i++]." ".$row[$i++], $row[$i++], $row[$i++],
                    $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++]);
                array_push($res, $user->jsonSerialize());
            }
        }
        echo json_encode($res);
    }
}else if(isset($_POST['update_user_info'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $resp = "";
        $userid = $conn->real_escape_string($_POST['userId']);
        $seeking = $conn->real_escape_string($_POST['seeking']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $smoking = $conn->real_escape_string($_POST['smoker']);
        $drinking = $conn->real_escape_string($_POST['drinker']);
        $sql = "UPDATE profile SET Seeking = '{$seeking}', Drinker = '{$drinking}', Smoker = '{$smoking}' WHERE userID = '{$userid}'";
        $sqlQuery = "UPDATE user SET gender = '{$gender}' WHERE id = '{$userid}';";
        $result = $conn->query($sql);
        if ($conn->query($sql) === TRUE) {
            if ($conn->query($sqlQuery) === TRUE) {
                $resp = new SweetalertResponse(3,
                    'Updated User Info',
                    "Updated User Info Successfully",
                    SweetalertResponse::SUCCESS
                );
            } else {
                $resp = new SweetalertResponse(3,
                    'Failed to update User Info',
                    "Failed to Update User Info",
                    SweetalertResponse::ERROR
                );
            }

        }
    }

    echo $resp->jsonSerialize();

}
else if(isset($_POST['get_user_info'])){

    $uname = $conn->real_escape_string($_POST['username']);

    $mode = ctype_digit($uname) ? "res.id='{$uname}';" : "res.userName='{$uname}';";

    $sql = "SELECT res.id, userName,firstname,lastname,email, Description, age, Seeking, photoId, gender, Smoker, Drinker, town.town
                 FROM (SELECT user.id, user.firstname, user.lastname,
                 user.age, user.gender, user.userName,user.email,
             profile.photoId, profile.location, profile.Description, profile.Seeking, profile.Smoker, profile.Drinker  FROM user
            inner join profile
            on user.id = profile.userID) as res INNER JOIN town on town.id = res.location WHERE ".$mode;

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $res = $result->fetch_row();
            $user = new UserInfo($res[1], $res[2], $res[3], $res[4], $res[5], $res[6], $res[7], $res[8], $res[9], $res[10], $res[11], $res[0],$res[12], null) ;
            echo $user->jsonSerialize();
    }
}
else if(isset($_POST['get_all_tickets'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "SELECT userName,email,description,reason,date,queryNumber, status, archived FROM
                queries";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new Query($row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++], $row[$i++]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}else if(isset($_POST['updateTicket'])){
    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $sqlQuery = "";
        $number = $_POST['number'];
        if(isset($_POST['archived_ticket'])){
            $sql = $conn->real_escape_string($_POST['archived_ticket']);
            $sqlQuery = "UPDATE queries SET archived = 1 WHERE queryNumber='{$number}'";
        }else if(isset($_POST['close_ticket'])){
            $sql = $conn->real_escape_string($_POST['close_ticket']);
            $sqlQuery = "UPDATE queries SET status = 'Closed' WHERE queryNumber='{$number}'";
        }else if(isset($_POST['unresolved_ticket'])){
            $sql = $conn->real_escape_string($_POST['unresolved_ticket']);
            $sqlQuery = "UPDATE queries SET status = 'Unresolved' WHERE queryNumber='{$number}'";
        }


        if ($conn->query($sqlQuery) === TRUE) {
            $resp = new SweetalertResponse(3,
                'Updated ticket successfully',
                "Updated ticket ".$number." Successfully",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(3,
                'Failed to update ticket',
                "Failed to update ticket ".$number,
                SweetalertResponse::ERROR
            );
        }
        echo $resp->jsonSerialize();

    }

}else if(isset($_POST['deleteTicket'])){

    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $number = $_POST['number'];

        $sql = "DELETE FROM queries WHERE queryNumber = '{$number}'";

        if ($conn->query($sql) === TRUE) {
            $resp = new SweetalertResponse(3,
                'Deleted ticket Successfully',
                "Deleted ticket ".$number." Successfully",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(3,
                'Failed to delete ticket',
                "Failed to delete ticket ".$number,
                SweetalertResponse::ERROR
            );
        }
        echo $resp->jsonSerialize();

    }

}
else if(isset($_POST['resend_verification_email'])){

    $email = $_POST['email'];
    $uname = $_POST['username'];

    $semail = new Email($email, $uname);
    $semail->sendRegisterEmail(Email::VERIFY);

}else if(isset($_POST['change_user_admin_status'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $username = $conn->real_escape_string($_POST['username']);
        $change = $conn->real_escape_string($_POST['change']);

        if($change === "Add"){
            $sql = "UPDATE user SET admin = true WHERE userName = '{$username}'";
        }else if($change === "Remove"){
            $sql = "UPDATE user SET admin = false WHERE userName = '{$username}'";
        }

        if ($conn->query($sql) === TRUE) {
            $resp = new SweetalertResponse(1,
                '',
                "",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(2,
                '',
                "",
                SweetalertResponse::SUCCESS
            );
        }
        echo $resp->jsonSerialize();

    }
}else if(isset($_POST['update_user'])){
    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $res = "";
        $sqlQuery = "";
        $action = $_POST['action'];
        $username = $conn->real_escape_string($_POST['user']);
        $email = $_POST['email'];

        if($action === 'block' || $action === 'delete') {
            $name = $conn->real_escape_string($_POST['name']);
            $sender_name = $_POST['sender_name'];
            $reason = $_POST['reason'];
            $date = date("Y/m/d");

            if ($action === 'block') {
                $sql = "update profile set blocked = '1' where userID = (select id from user where username = '{$username}');"."insert into blocked (blocked_user, blocked_date, blockee, reason) values ('{$username}', '{$date}', '{$sender_name}', '{$reason}');";
            } else if ($action === 'delete') {
                $sqlDisableForeignKeys = "SET FOREIGN_KEY_CHECKS = 0";
                $sqlDeleteProfile = "DELETE FROM profile where userID = '{$username}';";
                $sqlDeleteConnections = "DELETE FROM connections WHERE userID1 = '{$username}' OR userID2 = '{$username}';";
                $sqlDeleteFromInterest = "DELETE FROM interests WHERE userID = '{$username}';";
                $sqlDeleteUser = "DELETE FROM user WHERE id = '{$username}';";
                $sqlEnableForeignKeyChecks = "SET FOREIGN_KEY_CHECKS = 0;";
                $sqlQuery = $sqlDisableForeignKeys.$sqlDeleteFromInterest.$sqlDeleteConnections.$sqlDeleteProfile.$sqlDeleteUser;
            }


            if ($conn->multi_query($sql) === TRUE) {
                $email = new Email($email, $name);
                $email->sendMessage($reason === 'delete' ? 3 : 2, $reason, $action, $sender_name);
                if ($reason === 'block') {
                        $resp = new SweetalertResponse(1,
                            '',
                            "" ,
                            SweetalertResponse::SUCCESS
                        );


                } else if ($reason === 'delete') {
                    $resp = new SweetalertResponse(2,
                        '',
                        '',
                        SweetalertResponse::SUCCESS
                    );
                }

            }
        }else{
            if($action === 'activate'){
                $sql = "update user set registered = '1' where userName ='{$username}';";
            }else if($action === 'unblock'){
                $sql = "update profile set blocked = '0' where userID = (select id from user where username = '{$username}');"."DELETE FROM blocked WHERE blocked_user = '{$username}';";
            }
            if ($conn->multi_query($sql) === TRUE) {

                if($action === 'activate'){
                    $email = new Email($email, $username);
                    $email->sendMessage(4, "Account Activated", "Activate", "customerservicesteam@idate.ie");
                }else if($action === 'unblock'){
                    $email = new Email($email, $username);
                    $email->sendMessage(5, "Account Unblocked", "Unblock", "customerservicesteam@idate.ie");
                }
                $resp = new SweetalertResponse(1,
                        '',
                        "",
                        SweetalertResponse::SUCCESS
                );

            }else{
                $resp = new SweetalertResponse(2,
                    '',
                    "",
                    SweetalertResponse::WARNING
                );
            }
        }
    }
    echo $resp->jsonSerialize();

}else if(isset($_POST['get_block_reason'])){

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $username = $conn->real_escape_string($_POST['username']);
        $sql = "select * from blocked where blocked_user = '{$username}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $res = $result->fetch_row();
            $blocked = new BlockReason($res[1], $res[2], $res[3], $res[4]);
            echo $blocked->jsonSerialize();
        }
    }
}else if(isset($_POST['save_user_info'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $resp = "";
        if(isset($_POST['username'])){
            $username = $conn->real_escape_string($_POST['username']);
            $fname = $conn->real_escape_string($_POST['firstname']);
            $lname = $conn->real_escape_string($_POST['lastname']);
            $email = $conn->real_escape_string($_POST['email']);
            $sql = "UPDATE user SET userName = '{$username}', email = '{$email}', firstname = '{$fname}', lastname = '{$lname}' WHERE userName = '{$username}'";
        }else if(isset($_POST['about_me'])){
            $id = $conn->real_escape_string($_POST['user_id']);
            $me = $conn->real_escape_string($_POST['about_me']);
            $sql = "UPDATE profile SET Description = '{$me}' WHERE userID = '{$id}' ";
        }else if(isset($_POST['seeking'])){

        }

        $result = $conn->query($sql);

        if ($result === true) {
            $resp = new SweetalertResponse(1,
                'Success',
                "Information Saved",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(1,
                'Failed',
                "Failed to save information",
                SweetalertResponse::ERROR
            );
        }
    }
    echo $resp->jsonSerialize();
}else if(isset($_POST['save_user_city'])){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $resp = "";
        $userid = $conn->real_escape_string($_POST['userId']);
        $city = $conn->real_escape_string($_POST['city']);

        $result = $conn->query("UPDATE profile SET location = (SELECT id FROM town WHERE town = '{$city}') WHERE userID = '{$userid}';");

        if ($result === true) {
            $resp = new SweetalertResponse(1,
                'Success',
                "Information Saved",
                SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(1,
                'Failed',
                "Failed to save information",
                SweetalertResponse::ERROR
            );
        }
    }
    echo $resp->jsonSerialize();
}else if(isset($_POST['get_citites'])){
    $resp = array();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {


        $result = $conn->query("SELECT town FROM town;");

        if($result->num_rows > 0) {
            for($x = 0; $x < $result->num_rows; $x++){
                array_push($resp, $result->fetch_row()[0]);
            }
        }
    }
    echo json_encode($resp);
}else if(isset($_POST['delete_user'])){

    $resp = "";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $userid = $conn->real_escape_string($_POST['userId']);
        $sqlDisableForeignKeys = "SET FOREIGN_KEY_CHECKS = 0";
        $sqlDeleteProfile = "DELETE FROM profile where userID = '{$userid}';";
        $sqlDeleteConnections = "DELETE FROM connections WHERE userID1 = '{$userid}' OR userID2 = '{$userid}';";
        $sqlDeleteFromInterest = "DELETE FROM interests WHERE userID = '{$userid}';";
        $sqlDeleteUser = "DELETE FROM user WHERE id = '{$id}';";
        $sqlEnableForeignKeyChecks = "SET FOREIGN_KEY_CHECKS = 0;";

        $sqlQuery = $sqlDisableForeignKeys.$sqlDeleteFromInterest.$sqlDeleteConnections.$sqlDeleteProfile.$sqlDeleteUser;
        if($conn->multi_query($sqlQuery) === TRUE){
            $resp = new SweetalertResponse(1,
            'Closed Account Successfully',
            "Account Closed Successfully",
            SweetalertResponse::SUCCESS
            );
        }else{
            $resp = new SweetalertResponse(1,
                'Failed to close account',
                "Failed close account successfully",
                SweetalertResponse::ERROR
            );
        }

    }
    echo $resp->jsonSerialize();
}
ob_end_flush();