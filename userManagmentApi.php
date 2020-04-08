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

        $sql = "SELECT id,userName,firstname,lastname,email,blocked,registered,admin FROM
                (SELECT a.id, a.userName, a.firstname, a.lastname, a.email, a.registered,a.admin, b.userID, b.blocked 
                FROM user as a LEFT JOIN(select userID, blocked from profile group by userID) as b on a.id = b.userID) as users";

        $result = $conn->query($sql);
        $res = "[";
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $i = 0;
                $user = new UserManagment($row[$i++], $row[$i++], $row[$i++]." ".$row[$i++], $row[$i++], $row[$i++],
                    $row[$i++], $row[$i++]);
                $res = $res.$user->jsonSerialize().",";
            }

            $res = substr($res, 0,strlen($res)-1);
        }
        $res = $res."]";
        echo $res;
    }
}
else if(isset($_POST['get_user_info'])){

    $uname = $conn->real_escape_string($_POST['username']);

    $sql = "";
    $mode = ctype_digit($uname) ? "id='{$uname}';" : "userName='{$uname}';";

        $sql = "SELECT id, userName,firstname,lastname,email, Description, age, Seeking, photoId, gender
                 FROM (SELECT user.id, user.firstname, user.lastname, 
                 user.age, user.gender, user.userName,user.email, 
             profile.photoId, profile.location, profile.Description, profile.Seeking  FROM user
            inner join profile
            on user.id = profile.userID) AS res
            WHERE {$mode}";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            $res = $result->fetch_row();
            $user = new UserInfo($res[1], $res[2], $res[3], $res[4], $res[5], $res[6], $res[7], $res[8], $res[9]) ;
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
            $sqlQuery = "UPDATE queries SET archived = 'True' WHERE id='{$number}'";
        }else if(isset($_POST['close_ticket'])){
            $sql = $conn->real_escape_string($_POST['close_ticket']);
            $sqlQuery = "UPDATE queries SET status = 'Closed' WHERE id='{$number}'";
        }else if(isset($_POST['unresolved_ticket'])){
            $sql = $conn->real_escape_string($_POST['unresolved_ticket']);
            $sqlQuery = "UPDATE queries SET status = 'Unresolved' WHERE id='{$number}'";
        }


        if ($conn->query($sql) === TRUE) {
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

}else if(isset($_POST['resend_verification_email'])){

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
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "";
        $username = $conn->real_escape_string($_POST['user']);
        $name = $conn->real_escape_string($_POST['name']);
        $sender_name = $_POST['sender_name'];
        $action = $_POST['action'];
        $reason = $_POST['reason'];
        $email = $_POST['email'];
        $date = new DateTime();
        $date = getdate($date->getTimestamp());

        if($reason === 'block') {
            $sql = "update profile set blocked = '1' where userID = (select id from user where username = '{$username}');";
            $sqlQuery = "insert into blocked (blocked_user, blocked_date, blockee, reason) values '{$username}', '{$date}', '{$sender_name}', '$reason'";
        }else if($reason === 'delete'){
            $sql = "DELETE FROM profile where userID = (SELECT id FROM user where userName = '{$username}')";
        }



        if ($conn->query($sql) === TRUE) {

            $email = new Email($email, $name);
            $email->sendMessage($reason === 'delete' ? 3 : 2, $reason, $action, $sender_name);


            if($reason === 'block') {
                $conn->query($sqlQuery);
                $resp = new SweetalertResponse(1,
                    '',
                    "",
                    SweetalertResponse::SUCCESS
                );
            }else if($reason === 'delete'){
                $resp = new SweetalertResponse(2,
                    '',
                    "",
                    SweetalertResponse::SUCCESS
                );
            }

        }
        echo $resp->jsonSerialize();


    }
}else if(isset($_POST['get_block_reason'])){

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $username = $conn->real_escape_string($_POST['username']);
        $sql = "select * from blocked where blocked_user = '{$username}'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $res = $result->fetch_row();
            $blocked = new BlockReason($res[0], $res[1], $res[2], $res[4]);
            echo $res->jsonSerialize();
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
}
ob_end_flush();